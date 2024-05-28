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
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $positions = $this->positionRepository->findPositionsForCurrentWeek();

        return $this->render('home/index.html.twig', [
            'positions' => $positions,
        ]);
    }
}