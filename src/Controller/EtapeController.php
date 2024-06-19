<?php

namespace App\Controller;

use App\Entity\Etape;
use App\Form\EtapeType;
use App\Repository\EtapeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/etape')]
class EtapeController extends AbstractController
{
    #[Route('/', name: 'app_etape_index', methods: ['GET'])]
    public function index(EtapeRepository $etapeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        return $this->render('etape/index.html.twig', [
            'etapes' => $etapeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_etape_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        $etape = new Etape();
        $form = $this->createForm(EtapeType::class, $etape);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etape);
            $entityManager->flush();

            return $this->redirectToRoute('app_etape_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etape/new.html.twig', [
            'etape' => $etape,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etape_show', methods: ['GET'])]
    public function show(Etape $etape): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        return $this->render('etape/show.html.twig', [
            'etape' => $etape,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etape_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etape $etape, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        $form = $this->createForm(EtapeType::class, $etape);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etape_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etape/edit.html.twig', [
            'etape' => $etape,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etape_delete', methods: ['POST'])]
    public function delete(Request $request, Etape $etape, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete' . $etape->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($etape);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etape_index', [], Response::HTTP_SEE_OTHER);
    }
}
