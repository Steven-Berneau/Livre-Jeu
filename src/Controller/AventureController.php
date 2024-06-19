<?php

namespace App\Controller;

use App\Entity\Aventure;
use App\Form\AventureType;
use App\Repository\AventureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/aventure')]
class AventureController extends AbstractController
{
    #[Route('/', name: 'app_aventure_index', methods: ['GET'])]
    public function index(AventureRepository $aventureRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        return $this->render('aventure/index.html.twig', [
            'aventures' => $aventureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_aventure_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        $aventure = new Aventure();
        $form = $this->createForm(AventureType::class, $aventure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aventure);
            $entityManager->flush();

            return $this->redirectToRoute('app_aventure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('aventure/new.html.twig', [
            'aventure' => $aventure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aventure_show', methods: ['GET'])]
    public function show(Aventure $aventure): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        return $this->render('aventure/show.html.twig', [
            'aventure' => $aventure,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_aventure_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Aventure $aventure, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        $form = $this->createForm(AventureType::class, $aventure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_aventure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('aventure/edit.html.twig', [
            'aventure' => $aventure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aventure_delete', methods: ['POST'])]
    public function delete(Request $request, Aventure $aventure, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete' . $aventure->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($aventure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_aventure_index', [], Response::HTTP_SEE_OTHER);
    }
}
