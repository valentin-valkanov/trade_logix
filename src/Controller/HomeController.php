<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\PositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct( private PositionRepository $positionRepository)
    {
    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $positions = $this->positionRepository->findPositionsForCurrentWeek();
        $openPositions = $this->positionRepository->findOpenPositions();

        return $this->render('home/index.html.twig', [
            'positions' => $positions,
            'openPositions' => $openPositions,
        ]);
    }
}