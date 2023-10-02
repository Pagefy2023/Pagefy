<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\LivreRepository;

class PagefyController extends AbstractController
{
    #[Route('/', name: 'app_pagefy')]
    public function index(LivreRepository $livreRepo): Response
    {
        $livres = $livreRepo->findAll();

        return $this->render('pagefy/index.html.twig', [
            'controller_name' => 'PagefyController',
            'livres' => $livres
        ]);
    }

    #[Route('/aPropos', name: 'aPropos_pagefy')]
    public function aPropos(): Response
    {
        return $this->render('pagefy/aPropos.html.twig');
    }
    
    #[Route('/privacyPolicy', name: 'privacyPolicy_pagefy')]
    public function politiqueConf(): Response
    {
        return $this->render('pagefy/privacyPolicy.html.twig');
    }
    
    #[Route('/terms_and_conditions', name: 'termsConditions_pagefy')]
    public function terms_and_conditions(): Response
    {
        return $this->render('pagefy/termsConditions.html.twig');
    }
    
    #[Route('/contact', name: 'contact_pagefy')]
    public function contact(Request $request,MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
    
        $userEmail = $data['email'];
        $firstName = $data['prenom'];
        $lastName = $data['nom'];
        $content = $data['message'];
    
        $email = (new Email())
            ->from($userEmail)
            ->to('rd46wzx@gmail.com')
            ->text("Bonjour Madame, Monsieur,\n\nJe suis $firstName $lastName.\n\n$content");
    
        try {
            $mailer->send($email);
            return $this->redirectToRoute('app_pagefy');
        } catch (\Exception $e) {
            $errorMessage = "Une erreur s'est produite lors de l'envoi du courrier électronique. Veuillez réessayer.";
        }
    } else {
        $errorMessage = "Le formulaire n'est pas valide. Veuillez vérifier les informations saisies et réessayer.";
    }


        return $this->render('pagefy/contact.html.twig', [
            'form' => $form
        ]);
    }
}
