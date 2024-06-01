<?php

namespace App\Command;

use App\Entity\PortfolioHeatMetrics;
use App\Repository\PortfolioHeatMetricsRepository;
use App\Repository\PositionRepository;
use App\Service\PortfolioHeat;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:save-daily-metrics',
    description: 'Add a short description for your command',
)]
class SaveDailyMetricsCommand extends Command
{
    public function __construct(
        private PortfolioHeat $portfolioHeat,
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager,
        private PortfolioHeatMetricsRepository $portfolioHeatMetricsRepository,
        private PositionRepository $positionRepository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Save daily portfolio heat metrics');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $date = new \DateTimeImmutable();

        // Check if an entry for the current date already exists
        $existingMetric = $this->portfolioHeatMetricsRepository->findByDate($date);

        if ($existingMetric) {
            $this->logger->info('Metrics for today already exist. No new entry created.');
            return Command::SUCCESS;
        }

        $this->portfolioHeat->saveDailyMetrics();

        $this->logger->info('Daily metrics saved successfully.');

        return Command::SUCCESS;
    }
}
