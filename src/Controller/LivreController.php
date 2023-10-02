<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Form\LivreType;
use App\Entity\Chapitre;
use App\Entity\Categorie;
use App\Form\LivreSearchType;
use App\Repository\LivreRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/livre')]
class LivreController extends AbstractController
{
    #[Route('/admin/', name: 'app_livre_index', methods: ['GET'])]
    public function index(LivreRepository $repo, #[Autowire('%couverture_directory%')] string $couvertureDir, Request $request, Chapitre $chapitre): Response
    {
        
    $livres = $repo->findAll();
    
    $chapitres = [];

    $livreId = $request->get('id');
    if ($livreId) {
        $livre = $repo->find($livreId);
        if ($livre) {
            $chapitres = $livre->getChapitres();
        }
    }

        return $this->render('livre/index.html.twig', [
            'livres' => $repo->findAll(),
            'chapitres' => $chapitres,
            
        ]);
    }

    #[Route('/search', name: 'livre_search', methods: ['GET'])]
    public function search(LivreRepository $repo, #[Autowire('%couverture_directory%')] string $couvertureDir, Request $request , PaginatorInterface $paginator): Response
{
    $titre = $request->query->get('titre'); 

    $form = $this->createForm(LivreSearchType::class, null , ['method' => 'GET']);
    $form->handleRequest($request);

    $livres = [];

    if ($form->isSubmitted() && $form->isValid()) {
        // dump($titre);
        $titre = $form->get('titre')->getData();

        $livres = $repo->searchByTitre($titre);
    }

    $pagination = $paginator->paginate(
        $livres,
        $request->query->get('page', 1),
        15
    );

    $pagination->setParam('titre', $titre);

    return $this->render('livre/search.html.twig', [
        'form' => $form->createView(),
        'livres' => $livres,
        'pagination' => $pagination
    ]);
}

    #[Route('/admin/new', name: 'app_livre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, #[Autowire('%couverture_directory%')] string $couvertureDir): Response
    {
        $livre = new Livre();
        $categorie = $entityManager->getRepository(Categorie::class)->findAll();
        $auteur = $entityManager->getRepository(Auteur::class)->findAll();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->get('categorie')->getData();
            $auteur = $form->get('auteur')->getData();
            if ($couverture = $form->get('couverture')->getData()) {
               $fileName = uniqid().'.'.$couverture->guessExtension();
               $couverture->move($couvertureDir, $fileName);
            }
            $livre->setCouverture($fileName);
            $livre->setCategorie($categorie);
            $livre->setAuteur($auteur);
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('app_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_livre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livre $livre, EntityManagerInterface $entityManager, #[Autowire('%couverture_directory%')] string $couvertureDir): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($couverture = $form->get('couverture')->getData()) {
                $fileName = uniqid().'.'.$couverture->guessExtension();
                $couverture->move($couvertureDir, $fileName);
             }
            $livre->setCouverture($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_livre_show', methods: ['GET'])]
    public function show(Livre $livre, CategorieRepository $repoCat, LivreRepository $repo): Response
    {

        $categories = $livre->getCategorie();
        $chapitres = $livre->getChapitres();


        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
            'categories' => $categories,
            'chapitres' => $chapitres,
        ]);
    }


    #[Route('/admin/{id}/delete', name: 'app_livre_delete', methods: ['POST'])]
    public function delete(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($livre);
            $entityManager->flush();
        }

    return $this->redirectToRoute('app_livre_index', [], Response::HTTP_SEE_OTHER);
    }

}
