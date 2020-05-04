<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request,\Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

         // Ici nous enverrons l'e-mail
        $message = (new \Swift_Message('Nouveau contact'))
            // On attribue l'expéditeur
            ->setFrom($contact['email'])

            // On attribue le destinataire
            ->setTo('ludovic.cochain@gmail.com')

            // On crée le texte avec la vue
            ->setBody(
                $this->renderView(
                    'emails/contact.html.twig', compact('contact')
                ),
                'text/html'
        );
            // On envoie le message
            $mailer->send($message);

            // dd($contact);
            $this->addFlash('notice', 'Votre message est bien envoyé');   // Permet un message flash de renvoi
            return $this->redirectToRoute('accueil');
        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
