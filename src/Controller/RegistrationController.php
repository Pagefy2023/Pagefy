<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request,MailerInterface $mailer, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );


            // Générer un token de confirmation unique
            $confirmationToken = bin2hex(random_bytes(32));
            $user->setConfirmationToken($confirmationToken);

            $entityManager->persist($user);
            $entityManager->flush();

            // Envoyer l'e-mail de confirmation
            $email = (new Email())
                ->from('confirmation-mail@pagefy.fr')
                ->to($user->getEmail())
                ->subject('Confirmation d\'inscription')
                ->html($this->renderView('confirmation/confirmation.html.twig', ['confirmationToken' => $confirmationToken]));

            $mailer->send($email);


            // Rediriger l'utilisateur vers une page de confirmation
            return $this->render('confirmation/confirmMessage.html.twig');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
