<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlaybookController extends AbstractController
{
    private array  $playbookEntries = [
        1=> ['title' => 'Playbook W1', 'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
        2=> ['title' => 'Playbook W2', 'body' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'],

    ];
    #[Route('/playbook/form', name: 'app_home_showplaybookform')]
    public function showPlaybookForm():Response
    {
        return $this->render('playbook/playbook_form.html.twig');
    }

    #[Route('/playbook/store', name: 'app_home_storeplannedtrades')]
    public function storePlaybook(Request $request): Response
    {
        // Logic to store planned trades in the database
        // Example: Get form data
        $title = $request->request->get('title');
        $body = $request->request->get('body');

        // Example: Process form data and save to database

        // Redirect back to the playbook form or display a success message
        return $this->redirectToRoute('app_notebook_showplaybook', ['saved']);
    }

    #[Route('playbook/show', name: 'app_notebook_showplaybook')]
    public function showPlaybookList():Response
    {
        // Render the playbook template and pass the fake data to it
        return $this->render('playbook/playbook.html.twig', [
            'playbookEntries' => $this->playbookEntries,
        ]);
    }
    #[Route('/playbook/{id}', name: 'app_playbook_show')]
    public function showPlaybook(int $id): Response
    {
        if(!array_key_exists($id, $this->playbookEntries)){
            throw $this->createNotFoundException('The playbook does not exist');
        }

        return $this->render('playbook/single_playbook.html.twig', [
            'playbook' => $this->playbookEntries[$id]
        ]);
    }
}