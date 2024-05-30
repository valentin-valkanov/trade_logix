<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\PositionRepository;
use App\Service\PortfolioHeat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private PositionRepository $positionRepository,
        private PortfolioHeat $portfolioHeat
    )
    {
    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $positions = $this->positionRepository->findPositionsForCurrentWeek();
        $openPositions = $this->positionRepository->findOpenPositions();
        $accountBalance = 10000; // Replace with actual account balance fetching logic

        $combinedRisk = $this->portfolioHeat->findCombinedRisk();
        $combinedRiskPercent = $this->portfolioHeat->findCombinedRiskPercent($accountBalance);
        $totalOpenPositions = $this->portfolioHeat->findTotalOpenPositions();
        $newTrades = count($this->positionRepository->findNewTrades());
        $closedTrades = count($this->positionRepository->findPositionsForCurrentWeek());
        $closedPnL = $this->portfolioHeat->getClosedPnL();
        $openPnL = $this->portfolioHeat->getOpenPnL();
        $account = $accountBalance + $closedPnL;



        return $this->render('home/index.html.twig', [
            'positions' => $positions,
            'openPositions' => $openPositions,
            'combinedRisk' => $combinedRisk,
            'combinedRiskPercent' => $combinedRiskPercent,
            'totalOpenPositions' => $totalOpenPositions,
            'newTrades' => $newTrades,
            'closedTrades' => $closedTrades,
            'closedPnL' => $closedPnL,
            'openPnL' => $openPnL,
            'account' => $account
        ]);
    }
}