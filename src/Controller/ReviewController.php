<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReviewController extends AbstractController
{
    #[Route('/review/form', name: 'app_review_showplaybookform')]
    public function showReviewForm():Response
    {

        return $this->render('review/review_form.html.twig');
    }

    #[Route('/review/store', name: 'app_review_storeplaybook')]
    public function storeReview(Request $request): Response
    {

        // Logic to store planned trades in the database
        // Example: Get form data
        $title = $request->request->get('title');
        $body = $request->request->get('body');

        // Example: Process form data and save to database

        // Redirect back to the playbook form or display a success message
        return $this->redirectToRoute('app_review_showplaybook');
    }

    #[Route('review/show', name: 'app_review_showplaybook')]
    public function showReview():Response
    {
        // Generate fake playbook entries for demonstration
        $reviewEntries = [
            ['title' => 'Review W1', 'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
            ['title' => 'Review W2', 'body' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'],
            // Add more fake entries as needed
        ];

        // Render the playbook template and pass the fake data to it
        return $this->render('review/review.html.twig', [
            'reviewEntries' => $reviewEntries,
        ]);
    }
}