<?php

namespace App\Controller;

use App\Entity\Personnage;
use App\Repository\PersonnageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\PersonnageType;
use App\Repository\AventureRepository;
use App\Repository\EtapeRepository;
use App\Repository\PartieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Partie;
use App\Repository\AlternativeRepository;

class JouerController extends AbstractController
{
    #[Route('/jouer', name: 'app_jouer')]
    public function index(PersonnageRepository $personnageRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $personnages = $personnageRepository->findBy(["user" => $user = $this->getUser()]);
        return $this->render('jouer/index.html.twig', [
            'personnages' => $personnages,
        ]);
    }
    #[Route('jouer/new', name: 'app_jouer_new')]
    public function newPersonnage(Request $request, EntityManagerInterface $entityManager, PersonnageRepository $personnageRepository): Response
    {
        $personnage = new Personnage();
        $form = $this->createForm(PersonnageType::class, $personnage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager->persist($personnage);
            // $entityManager->flush();
            $personnage->setUser($this->getUser());
            $personnageRepository->save($personnage, true);
            return $this->redirectToRoute('app_jouer', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jouer/new_personnage.html.twig', ['form' => $form, 'personnage' => $personnage]);
    }

    #[Route('/jouer/aventures/{idPersonnage}', name: 'app_choix_aventure', methods: ['GET'])]
    public function afficherAventures(PersonnageRepository $personnageRepository, $idPersonnage, AventureRepository $aventureRepository): Response
    {
        $personnage = $personnageRepository->find($idPersonnage);
        $aventures = $aventureRepository->findAll();
        return $this->render('jouer/aventures.html.twig', ['personnage' => $personnage, 'aventures' => $aventures]);
    }

    #[Route('/jouer/aventure/{idPersonnage}/{idAventure}', name: 'app_start_aventure', methods: ['GET'])]
    public function demarrerAventure(PersonnageRepository $personnageRepository, AventureRepository $aventureRepository, PartieRepository $partieRepository, $idPersonnage, $idAventure, EntityManagerInterface $entityManager): Response
    {
        $personnage = $personnageRepository->find($idPersonnage);
        $aventure = $aventureRepository->find($idAventure);
        $partie = $partieRepository->findOneBy(array('aventurier' => $personnage, 'aventure' => $aventure));
        $isNewPartie = !isset($partie);
        if ($isNewPartie) {
            $isNewPartie = true;
            $partie = new Partie();
            $partie->setAventurier($personnage);
            $partie->setAventure($aventure);
            $partie->setEtape($aventure->getPremiereEtape());
            $partie->setDatePartie(new \DateTime('now'));
            $entityManager->persist($partie);
            $entityManager->flush();
        }
        return $this->render('jouer/aventure-start.html.twig', ['personnage' => $personnage, 'aventure' => $aventure, 'partie' => $partie]);
    }

    #[Route('/jouer/etape/{idPartie}/{idEtape}', name: 'app_play_aventure', methods: ['GET'])]
    public function JouerAventure($idEtape, $idPartie, EtapeRepository $etapeRepository, PartieRepository $partieRepository, EntityManagerInterface $entityManager)
    {
        $etape = $etapeRepository->find($idEtape);
        $partie = $partieRepository->find($idPartie);
        $partie->setEtape($etape);
        $entityManager->persist($partie);
        $entityManager->flush();
        if ($etape->getFinAventure() != NULL) {
            return $this->render('jouer/aventure-end.html.twig', ['partie' => $partie]);
        } else
            return $this->render('jouer/aventure-play.html.twig', ['etape' => $etape, 'partie' => $partie]);
    }
}
