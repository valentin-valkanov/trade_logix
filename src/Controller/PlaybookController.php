<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Playbook;
use App\Form\PlaybookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class PlaybookController extends AbstractController
{
   public function __construct(
       private EntityManagerInterface $entityManager,
       private CsrfTokenManagerInterface $csrfTokenManager
   )
   {
   }

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

        $playbook = new Playbook();
        $playbook->setTitle($title);
        $playbook->setBody($body);
        $playbook->setCreatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($playbook);
        $this->entityManager->flush();

        // Redirect back to the playbook form or display a success message
        return $this->redirectToRoute('app_notebook_showplaybook', ['saved']);
    }

    #[Route('playbook/show', name: 'app_notebook_showplaybook')]
    public function showPlaybookList():Response
    {
        $playbooks = $this->entityManager->getRepository(Playbook::class)->findAll();
        return $this->render('playbook/playbook.html.twig', [
            'playbookEntries' => $playbooks,
        ]);
    }
    #[Route('/playbook/{id}', name: 'app_playbook_show')]
    public function showPlaybook(int $id): Response
    {
        $playbook = $this->entityManager->getRepository(Playbook::class)->find($id);
        if(!$playbook){
            throw $this->createNotFoundException('The playbook does not exist');
        }

        return $this->render('playbook/single_playbook.html.twig', [
            'playbook' => $playbook
        ]);
    }
    #[Route('/playbook/delete/{id}', name: 'app_playbook_delete', methods: ['POST'])]
    public function deletePlaybook(int $id, Request $request)
    {
        $token = $request->get('_token');
        if(!$this->isCsrfTokenValid('delete-playbook', $token)){
            throw $this->createAccessDeniedException('Invalid CSRF token');
        }

        $playbook = $this->entityManager->getRepository(Playbook::class)->find($id);

        if(!$playbook){
            throw $this->createNotFoundException('The playbook does not exists');
        }

        $this->entityManager->remove($playbook);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_notebook_showplaybook');
    }

    #[Route('/playbook/edit/{id}', name: 'app_playbook_edit')]
    public function editPlaybook($id, Request $request):Response
    {
        $playbook = $this->entityManager->getRepository(Playbook::class)->find($id);
        if(!$playbook){
           throw $this->createNotFoundException('The playbook does not exists');
        }

        $form = $this->createForm(PlaybookType::class, $playbook);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('app_playbook_show', ['id' => $playbook->getId()]);
        }

        return $this->render('playbook/playbook_edit.html.twig', [
            'form' => $form->createView()
            ]);
    }
}