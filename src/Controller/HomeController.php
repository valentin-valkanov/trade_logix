<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]public function homepage(): Response
    {
        $homepage = 'Hello Traders';

        return new Response(
            '<html><body>Homepage: '.$homepage.'</body></html>'
        );
    }

}