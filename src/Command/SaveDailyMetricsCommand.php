<?php

namespace App\Command;

use App\Service\PortfolioHeat;
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
    public function __construct(private PortfolioHeat $portfolioHeat)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Save daily portfolio heat metrics');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->portfolioHeat->saveDailyMetrics();
            $io->success('Daily portfolio heat metrics saved successfully.');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('An error occurred while saving daily metrics: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
