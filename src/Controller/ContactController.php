<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/nous-contacter', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from('contact@rotary-portovecchio.org')
                ->to('contact@rotary-portovecchio.org')
                ->replyTo($contact->getEmail())
                ->subject('Nouveau message de contact sur le site du Rotary')
                ->htmlTemplate('contact/email.html.twig')
                ->locale('fr')
                ->context([
                    'username' => $contact->getFirstname() . ' ' . $contact->getLastname(),
                    'message' => $contact->getMessage(),
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
