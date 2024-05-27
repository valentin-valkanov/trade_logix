<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Position;
use App\Form\PositionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PositionController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route('position/show', name: 'app_closed_position_show_all')]
    public function showAllPositions(): Response
    {
        $positions = $this->entityManager->getRepository(Position::class)->findAll();

        return $this->render('position/closed_positions.html.twig', [
            'positions' => $positions,
        ]);
    }

    #[Route('position/add', name: 'app_position_add')]
    public function addPosition(Request $request)
    {
        $position = new Position();
        $form = $this->createForm(PositionType::class, $position);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($position);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_closed_position_show_all');
        }

        return $this->render('position/add_position_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('position/edit{id}', name: 'app_position_edit')]
    public function editPosition(Request $request, Position $position): Response
    {
        $form = $this->createForm(PositionType::class, $position);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush();
            return $this->redirectToRoute('app_closed_position_show_all');
        }

        return $this->render('position/edit_position_form.html.twig', [
            'form' => $form->createView(),
            'position' => $position
        ]);

    }
}