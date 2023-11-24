<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Chapitre;
use App\Form\ChapitreType;
use App\Repository\LivreRepository;
use App\Repository\ChapitreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/chapitre')]
class ChapitreController extends AbstractController
{

    #[Route('/moderator/livre/{id}', name: 'app_livre_chapitres', methods: ['GET'])]
    public function chapitresParLivre(Livre $livre): Response
    {  
        $chapitres = $livre->getChapitres();

        return $this->render('chapitre/index.html.twig', [
            'chapitres' => $chapitres,
            'livre' => $livre
        ]);
    }


    #[Route('/moderator/new', name: 'app_chapitre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chapitre = new chapitre();
        $form = $this->createForm(chapitreType::class, $chapitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $id_du_livre = $chapitre->getLivre()->getId();


            $entityManager->persist($chapitre);
            $entityManager->flush();

            return $this->redirectToRoute('app_livre_chapitres', ['id' => $id_du_livre], Response::HTTP_SEE_OTHER);


        }

        return $this->render('chapitre/new.html.twig', [
            'chapitre' => $chapitre,
            'form' => $form,
        ]);
    }



    #[Route('/userAbonnee/{id}/', name: 'app_chapitre_show', methods: ['GET'])]
    public function show(LivreRepository $livreRepo,Chapitre $chapitre): Response
    {  
        $livre = $chapitre->getLivre();
        $chapitres = $livre->getChapitres()->toArray();

        $index = array_search($chapitre, $chapitres);


        return $this->render('chapitre/show.html.twig', [
            'chapitre' => $chapitre,
            'chapitres' => $chapitres,
            'livre' => $livre,
            'index' => $index
        ]);
    }

    



    #[Route('/moderator/{id}/edit', name: 'app_chapitre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chapitre $chapitre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChapitreType::class, $chapitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $id_du_livre = $chapitre->getLivre()->getId();
            
            $entityManager->flush();

            return $this->redirectToRoute('app_livre_chapitres', ['id' => $id_du_livre], Response::HTTP_SEE_OTHER);

        }

        return $this->render('chapitre/edit.html.twig', [
            'chapitre' => $chapitre,
            'form' => $form,
        ]);
    }

    #[Route('/moderator/{id}', name: 'app_chapitre_delete', methods: ['POST'])]
    public function delete(Request $request, Chapitre $chapitre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chapitre->getId(), $request->request->get('_token'))) {
            $id_du_livre = $chapitre->getLivre()->getId();

            $entityManager->remove($chapitre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_livre_chapitres', ['id' => $id_du_livre], Response::HTTP_SEE_OTHER);

    }
}
