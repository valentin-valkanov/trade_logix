<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class ReviewController extends AbstractController
{
    public function __construct(

        private EntityManagerInterface $entityManager, private CsrfTokenManagerInterface $csrfTokenManager)
    {
    }

    #[Route('/review/form', name: 'app_review_showplaybookform')]
    public function showReviewForm():Response
    {

        return $this->render('review/review_form.html.twig');
    }

    #[Route('/review/store', name: 'app_review_storeplaybook')]
    public function storeReview(Request $request): Response
    {
        // Get form data
        $title = $request->request->get('title');
        $body = $request->request->get('body');

        $review = new Review();
        $review->setTitle($title);
        $review->setBody($body);
        $review->setCreatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($review);
        $this->entityManager->flush();

        // Redirect to the review list to prevent resubmission
        return $this->redirectToRoute('app_review_showplaybook');
    }

    #[Route('review/show', name: 'app_review_showplaybook')]
    public function showReviewsList():Response
    {
        $reviews = $this->entityManager->getRepository(Review::class)->findAll();
        return $this->render('review/review.html.twig', [
            'reviewEntries' => $reviews,
        ]);
    }

    #[Route('/review/{id}', name: 'app_review_show')]
    public function showReviewById(int $id): Response
    {
        $review = $this->entityManager->getRepository(Review::class)->find($id);

        if(!$review){
            throw $this->createNotFoundException('The review does not exist');
        }

        return $this->render('review/single_review.html.twig', [
            'review' => $review,
        ]);
    }

    #[Route('/review/delete/{id}', name: 'app_review_delete', methods: ['POST'])]
    public function deleteReview(int $id, Request $request): Response
    {
        $token = $request->get('_token');
        if(!$this->isCsrfTokenValid('delete-review', $token)){
            throw $this->createAccessDeniedException('Invalid CSRF token');
        }

        $review = $this->entityManager->getRepository(Review::class)->find($id);

        if(!$review){
            throw $this->createNotFoundException('The review does not exist');
        }

        $this->entityManager->remove($review);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_review_showplaybook');
    }

    #[Route('/review/edit/{id}', name: 'app_review_edit')]
    public function editReview(Request $request, int $id)
    {
        $review = $this->entityManager->getRepository(Review::class)->find($id);

        if(!$review){
            throw $this->createNotFoundException('The review does not exist');
        }

        $form = $this->createForm(ReviewType::class, $review);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_review_show', ['id' => $review->getId()]);
        }

        return $this->render('review/edit_review.html.twig', [
            'form' => $form->createView()
        ]);
    }
}