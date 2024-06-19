<?php

namespace App\Controller;

use App\Entity\Alternative;
use App\Form\AlternativeType;
use App\Repository\AlternativeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/alternative')]
class AlternativeController extends AbstractController
{
    #[Route('/', name: 'app_alternative_index', methods: ['GET'])]
    public function index(AlternativeRepository $alternativeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        return $this->render('alternative/index.html.twig', [
            'alternatives' => $alternativeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_alternative_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        $alternative = new Alternative();
        $form = $this->createForm(AlternativeType::class, $alternative);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($alternative);
            $entityManager->flush();

            return $this->redirectToRoute('app_alternative_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('alternative/new.html.twig', [
            'alternative' => $alternative,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_alternative_show', methods: ['GET'])]
    public function show(Alternative $alternative): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        return $this->render('alternative/show.html.twig', [
            'alternative' => $alternative,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_alternative_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Alternative $alternative, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        $form = $this->createForm(AlternativeType::class, $alternative);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_alternative_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('alternative/edit.html.twig', [
            'alternative' => $alternative,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_alternative_delete', methods: ['POST'])]
    public function delete(Request $request, Alternative $alternative, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete' . $alternative->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($alternative);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_alternative_index', [], Response::HTTP_SEE_OTHER);
    }
}
