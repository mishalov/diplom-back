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
    public function getServersList()
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
}
