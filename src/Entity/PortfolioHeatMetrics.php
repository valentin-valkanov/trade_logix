<?php

namespace App\Entity;

use App\Repository\PortfolioHeatMetricsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortfolioHeatMetricsRepository::class)]
#[ORM\Table(name: 'portfolio_heat_metrics', uniqueConstraints: [new ORM\UniqueConstraint(columns: ['date'])])]
class PortfolioHeatMetrics
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?float $combinedRisk = null;

    #[ORM\Column]
    private ?float $combinedRiskPercent = null;

    #[ORM\Column]
    private ?float $totalOpenPositions = null;

    #[ORM\Column]
    private ?int $newTrades = null;

    #[ORM\Column]
    private ?float $closedPositions = null;

    #[ORM\Column]
    private ?float $closedPnL = null;

    #[ORM\Column(nullable: true)]
    private ?float $openPnL = null;

    #[ORM\Column]
    private ?float $account = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCombinedRisk(): ?float
    {
        return $this->combinedRisk;
    }

    public function setCombinedRisk(float $combinedRisk): static
    {
        $this->combinedRisk = $combinedRisk;

        return $this;
    }

    public function getCombinedRiskPercent(): ?float
    {
        return $this->combinedRiskPercent;
    }

    public function setCombinedRiskPercent(float $combinedRiskPercent): static
    {
        $this->combinedRiskPercent = $combinedRiskPercent;

        return $this;
    }

    public function getTotalOpenPositions(): ?float
    {
        return $this->totalOpenPositions;
    }

    public function setTotalOpenPositions(float $totalOpenPositions): static
    {
        $this->totalOpenPositions = $totalOpenPositions;

        return $this;
    }

    public function getNewTrades(): ?int
    {
        return $this->newTrades;
    }

    public function setNewTrades(int $newTrades): static
    {
        $this->newTrades = $newTrades;

        return $this;
    }

    public function getClosedPositions(): ?float
    {
        return $this->closedPositions;
    }

    public function setClosedPositions(float $closedPositions): static
    {
        $this->closedPositions = $closedPositions;

        return $this;
    }

    public function getClosedPnL(): ?float
    {
        return $this->closedPnL;
    }

    public function setClosedPnL(float $closedPnL): static
    {
        $this->closedPnL = $closedPnL;

        return $this;
    }

    public function getOpenPnL(): ?float
    {
        return $this->openPnL;
    }

    public function setOpenPnL(?float $openPnL): static
    {
        $this->openPnL = $openPnL;

        return $this;
    }

    public function getAccount(): ?float
    {
        return $this->account;
    }

    public function setAccount(float $account): static
    {
        $this->account = $account;

        return $this;
    }
}
