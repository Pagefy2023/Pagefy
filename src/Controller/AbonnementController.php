<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbonnementController extends AbstractController
{
    #[Route('/abonnement/{id}', name: 'app_abonnement')]
    public function abonnement(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->redirectToRoute('user_not_found');
        }

        // Changer le rôle de l'utilisateur en "ROLE_USER"
        $user->setRoles(['ROLE_USER']); 

        $entityManager->flush();

        return $this->render('abonnement/index.html.twig', [
            'users' => $user,
        ]);
    }

    #[Route('/user-not-found', name: 'user_not_found')]
    public function userNotFound(): Response
    {
        // Page pour indiquer que l'utilisateur n'a pas été trouvé
        return $this->render('abonnement/user_not_found.html.twig');
    }


}
