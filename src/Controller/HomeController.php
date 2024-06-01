<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\PortfolioHeatMetricsRepository;
use App\Repository\PositionRepository;
use App\Service\PortfolioHeat;
use App\Utils\DateUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private PositionRepository $positionRepository,
        private PortfolioHeat $portfolioHeat,
        private PortfolioHeatMetricsRepository $portfolioHeatMetricsRepository,
        private DateUtils $dateUtils
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

        $weeklyMetrics = $this->portfolioHeatMetricsRepository->findMetricsForCurrentWeek();
        $weekRange = $this->dateUtils->getCurrentWeekRange();
        [$startOfWeek, $endOfWeek] = $weekRange;

        $metricsByDay = [];
        for ($date = clone $startOfWeek; $date <= $endOfWeek; $date->modify('+1 day')) {
            $metricsByDay[$date->format('Y-m-d')] = null;
        }

        foreach ($weeklyMetrics as $metric) {
            $metricsByDay[$metric->getDate()->format('Y-m-d')] = $metric;
        }


        return $this->render('home/index.html.twig', [
            'positions' => $positions,
            'openPositions' => $openPositions,
            'metricsByDay' => $metricsByDay,
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
