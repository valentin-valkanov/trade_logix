<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private MessageGenerator $generator
    )
    {
    }

    #[Route('/', name: 'app_homepage')]
    public function homepage(): Response
    {
        $homepage = 'TradeLogix';
        $message = $this->printMessage();

        return $this->render('home/homepage.html.twig', [
            'homepage' => $homepage,
            'message' => $message,
        ]);
    }

    public function printMessage(): string
    {
         $message = $this->generator->getHappyMessage();
         return $message;
    }

}