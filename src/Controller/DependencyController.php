<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Dependency;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DependencyController extends Controller
{
    /**
     * @Route("/api/dependency", methods={"POST"})
     */
    public function addDependency(Request $request)
    {
        $denependencyToCreate = json_decode($request->getContent())->dependency;
        $dependency = new Dependency($denependencyToCreate);
        $em = $this->getDoctrine()->getManager();
        $em->persist($dependency);
        $em->flush();
        return new Response(sprintf("Зависимости успешно добавлена!"));
    }

    /**
     * @Route("/api/dependency", methods={"GET"})
     */
    public function getDependencies(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Dependency::class);
        $dependencies = $repository->findAll();
        return new JsonResponse($dependencies);
    }
}
