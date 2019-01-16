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


class ServersController extends AbstractController
{

    /**
     * @Route("/api/server", methods={"POST","HEAD"})
     */
    public function createServer(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $serverToCreate = json_decode($request->getContent())->server;
        $server = new Server($serverToCreate);
        $em->persist($server);
        $em->flush();
        return new Response(sprintf("Сервер успешно создан!"));
    }

    /**
     * @Route("/api/server", methods={"GET","HEAD"})
     */
    public function getServersList(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Server::class);
        $servers = $repository->findAll();
        return new JsonResponse($servers);
    }


    /**
     * @Route("/api/server", methods={"DELETE","HEAD"})
     */
    public function deleteServer(Request $request)
    {
        $toDelete = $this->getDoctrine()->getRepository(Server::class)->find(json_decode($request->getContent())->id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($toDelete);
        $entityManager->flush();
        return new Response(sprintf("Сервер успешно удален!"));
    }

    /**
     * @Route("/api/server/{id}", methods={"GET","HEAD"}, requirements={"id"="\d+"})
     */
    public function getServer(Request $request, $id)
    {
        $server = $this->getDoctrine()->getRepository(Server::class)->find($id);
        return new JsonResponse($server);
    }
    /**
     * @Route("/api/server/{id}/key", methods={"post","HEAD"}, requirements={"id"="\d+"})
     */
    public function changeAuth(Request $request, $id)
    {
        $newKey = new ServerKeys(json_decode($request->getContent())->hash, $id);
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();
        $server = $doctrine->getRepository(Server::class)->find($id);
        $oldKeyId = $server->getKeyId();
        if ($oldKeyId) {
            $oldKeyObject = $doctrine->getRepository(ServerKeys::class)->find($oldKeyId);
            $manager->remove($oldKeyObject);
        }
        $manager->persist($newKey);
        $manager->flush();
        $server->setKeyId($newKey->getId());
        $manager->flush();
        return new Response(sprintf("Ключ изменен успешно"));
    }
    /**
     * @Route("/api/server/{id}/key", methods={"GET","HEAD"}, requirements={"id"="\d+"})
     */
    public function getServerKey(Request $request, $id)
    {

        $serverKeyInfo = $this->getDoctrine()->getRepository(ServerKeys::class)->getKeyObject($id);
        return new JsonResponse($serverKeyInfo);
    }

}

