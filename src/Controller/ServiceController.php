<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Server;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ServerRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\ServerKeys;
use App\Service\OrchestratorService;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\DependencyInjection\Container;
use App\Entity\Service;
use function GuzzleHttp\json_decode;
use App\Entity\Dependency;

class ServiceController extends Controller
{
    /**
     * @Route("/api/services", methods={"GET","HEAD"})
     */
    public function getServices(Request $request)
    {
        $client = new Client(['base_uri' => 'http://192.168.56.102:5000/api/']);
        $serviceIds = json_decode($client->get("service")->getBody()->getContents());
        $repository = $this->getDoctrine()->getRepository(Service::class);
        $services = $repository->findAll();
        $servicesOut = array();
        foreach ($services as $key => $value) {
            $value->status = false;
            if (in_array($value->getServiceId(), $serviceIds) && $this->getUser()->getId() === $value->getOwner()->getId()) {
                $value->status = true;
            }
            $servicesOut[] = $value;
        }
        return new JsonResponse($servicesOut);
    }

    /**
     * @Route("/api/services", methods={"POST"})
     */
    public function createService(Request $request)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $serviceToCreate = json_decode($request->getContent())->service;
        $service = new Service($serviceToCreate, $user);

        $client = new Client(['base_uri' => 'http://192.168.56.102:5000/api/']);
        if (property_exists($serviceToCreate, 'dependencies') && is_array($serviceToCreate->dependencies)) {
            $repository = $this->getDoctrine()->getRepository(Dependency::class);
            foreach ($serviceToCreate->dependencies as $value) {
                $service->dependencies[] = $repository->find($value);
            }
        }

        $em->persist($service);
        $em->flush();
        var_dump($service->getDependencies()->toArray());
        $dependencies =  $service->getDependencies();
        $response = $client->post("service", [
            'json' => [
                "FileBase64" => $service->getFileBase64(),
                "Dependencies" => $dependencies->toArray(),
                "CountOfReplicas" => $service->getReplicas(),
                "Type" => $service->getType(),
                "UserId" => $user->getId(),
                "Id" => $service->getId()
            ],
        ])->getBody()->getContents();
        $response = json_decode($response);
        $service->setServiceId($response->dockerServiceId);
        $service->setPort($response->port);

        $em->flush();
        return new Response(sprintf("Сервис успешно создан!"));
    }

    /**
     * @Route("/api/services/{id}", methods={"DELETE"})
     */

    public function removeService(Request $request, $id)
    {
        $client = new Client(['base_uri' => 'http://192.168.56.102:5000/api/']);
        $response = $client->delete("service/$id")->getBody()->getContents();
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Service::class);
        $service = $repository->find($id);
        $em->remove($service);
        $em->flush();
        return new Response(sprintf("Сервис успешно удален!"));
    }


    /**
     * @Route("/api/services/{id}", methods={"POST"})
     */

    public function updateService(Request $request, $id)
    {
        $newServiceFields = json_decode($request->getContent())->service;
        $em = $this->getDoctrine()->getManager();
        $service = $em->getRepository(Service::class)->find($id);

        if (!$service) {
            throw $this->createNotFoundException(
                'Сервис не найден! Id ' . $id
            );
        }
        $service->setName($newServiceFields->name);
        $service->setReplicas($newServiceFields->replicas);
        $service->setfileBase64($newServiceFields->fileBase64);
        $client = new Client(['base_uri' => 'http://192.168.56.102:5000/api/']);
        $response = $client->post("service/$id", ['json' => [
            "FileBase64" => $newServiceFields->fileBase64
        ]])->getBody()->getContents();
        if (boolval($response)) {
            $em->flush();
            return new Response(sprintf("Сервис успешно изменен!"));
        } else {
            return new Response(sprintf("Ошибка при изменении сервиса!"));
        }
    }

    /**
     * @Route("/api/services/reinit", methods={"GET"})
     */
    public function reinitServices()
    {
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository(Service::class)->findAll();
        $servicesToSend = array_map(function ($service) {
            $dependencies =  $service->getDependencies();
            return [
                "FileBase64" => $service->getFileBase64(),
                "Dependencies" => $dependencies->toArray(),
                "CountOfReplicas" => $service->getReplicas(),
                "Type" => $service->getType(),
                "UserId" => $service->getOwner()->getId(),
                "Id" => $service->getId(),
                "Port" => $service->getPort(),
                "DockerServiceId" => $service->getServiceId()
            ];
        }, $services);
        $client = new Client(['base_uri' => 'http://192.168.56.102:5000/api/']);
        $response = $client->get("service/reinit", ['json' => $servicesToSend])->getBody()->getContents();
        var_dump(json_encode($response));
        return new JsonResponse($response);
    }
}
