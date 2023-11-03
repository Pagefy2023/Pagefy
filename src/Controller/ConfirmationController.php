<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConfirmationController extends AbstractController
{
    #[Route('/confirm/{token}', name: 'app_confirm')]
    public function confirm(Request $request,EntityManagerInterface $entityManager, $token)
    {
        // Vérifier la validité du token 
        $user = $entityManager->getRepository(User::class)->findOneBy(['confirmationToken' => $token]);

        if ($user) {
            // Activer le compte de l'utilisateur en effaçant le champ confirmationToken
            $user->setConfirmationToken(null);
        
            $entityManager->persist($user);
            $entityManager->flush();
        
            // Rediriger l'utilisateur vers une page de confirmation
            return $this->render('confirmation/success.html.twig');
            
        } else {
            // Rediriger l'utilisateur vers une page d'erreur
            return $this->render('confirmation/error.html.twig');
        }
        
    }
}
