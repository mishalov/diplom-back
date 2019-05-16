<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $userToCreate = json_decode($request->getContent())->user;
        $user = new User($userToCreate);
        $user->setPassword($encoder->encodePassword($user, $userToCreate->password));
        $em->persist($user);
        $em->flush();
        return new Response(sprintf('User successfully created'));
    }
    /**
     * @Route("/api/auth", methods={"GET","HEAD"})
     */
    public function getMe(Request $request)
    {
        $user = $this->getUser();
        return new JsonResponse($user);
    }

    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
}
