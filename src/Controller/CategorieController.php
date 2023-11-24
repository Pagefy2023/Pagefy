<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\LivreRepository;
use App\Form\CategorySearchFormType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/categorie')]
class CategorieController extends AbstractController
{
    #[Route('/moderator/', name: 'app_categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        

        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/all/{categoryId}', name: 'app_categorie_search', methods: ['GET'], defaults: ['categoryId' => null])]
public function search( CategorieRepository $repo, LivreRepository $repoLivre, $categoryId = null): Response
{

    $categories = $repo->findAll();

    $livres = [];
    if ($categoryId) {
        $livres = $repoLivre->findBy(['categorie' => $categoryId]);
    }

    return $this->render('categorie/categories.html.twig', [
        'categories' => $categories,
        'selectedCategoryId' => $categoryId,
        'livres' => $livres,
    ]);
}



    #[Route('/moderator/new', name: 'app_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/moderator/{id}', name: 'app_categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/moderator/{id}/edit', name: 'app_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }


    #[Route('/moderator/{id}', name: 'app_categorie_delete', methods: ['POST'])]
public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->request->get('_token'))) {
        // Supprimer la catégorie et la synchroniser avec les livres
        foreach ($categorie->getLivres() as $livre) {
            $livre->removeCategorie($categorie);
        }

        $entityManager->remove($categorie);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
}

}
