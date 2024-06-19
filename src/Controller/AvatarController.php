<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Form\AvatarType;
use App\Repository\AvatarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/avatar')]
class AvatarController extends AbstractController
{
    #[Route('/', name: 'app_avatar_index', methods: ['GET'])]
    public function index(AvatarRepository $avatarRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        return $this->render('avatar/index.html.twig', [
            'avatars' => $avatarRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_avatar_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        $avatar = new Avatar();
        $form = $this->createForm(AvatarType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avatar);
            $entityManager->flush();

            return $this->redirectToRoute('app_avatar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avatar/new.html.twig', [
            'avatar' => $avatar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avatar_show', methods: ['GET'])]
    public function show(Avatar $avatar): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        return $this->render('avatar/show.html.twig', [
            'avatar' => $avatar,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_avatar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avatar $avatar, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        $form = $this->createForm(AvatarType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_avatar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avatar/edit.html.twig', [
            'avatar' => $avatar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avatar_delete', methods: ['POST'])]
    public function delete(Request $request, Avatar $avatar, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NuLL, 'User tried to access a page without role having ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete' . $avatar->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($avatar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_avatar_index', [], Response::HTTP_SEE_OTHER);
    }
}
