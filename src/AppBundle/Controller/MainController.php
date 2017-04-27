<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ContactMessage;
use AppBundle\Form\Type\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="app_main_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/contact", name="app_main_contact")
     * @Method("GET|POST")
     */
    public function contactAction(Request $request)
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactType::class, $contactMessage)
                 ->handleRequest($request)
        ;

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.contact.contact_mailer')->sendMessage($contactMessage);
            $this->addFlash('success', 'Votre mail est bien parti ! Merci !!');

            return $this->redirectToRoute('app_main_contact');
        }

        return $this->render('main/contact.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}
