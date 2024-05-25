<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PositionController extends AbstractController
{
    #[Route('position/show', name: 'app_position_show_all')]
    public function showAllPositions(): Response
    {
        $positions = [
            1 => ['symbol' => 'EURUSD', 'type' =>'sell', 'volume' => 0.56, 'entry' => 1.1800, 'stop' => 1.2000],
            2 => ['symbol' => 'AUDCAD', 'type' =>'buy', 'volume' => 0.82, 'entry' => 0.8920, 'stop' => 0.8870],
        ];

        return $this->render('position/positions.html.twig', [
            'positions' => $positions,
        ]);
    }

    #[Route('position/add', name: 'app_position_add')]
    public function addPosition()
    {

    }
}