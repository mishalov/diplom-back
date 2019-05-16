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


class OrchestratorController extends AbstractController
{

    /**
     * @Route("/test/orchestrator", methods={"GET","HEAD"})
     */
    public function ping(Request $request, OrchestratorService $orhService)
    {
        $pingResponse = $orhService->ping();
        return new Response($pingResponse);
    }
}