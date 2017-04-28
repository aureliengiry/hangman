<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ContactMessage;
use AppBundle\Form\Type\ContactType;
use AppBundle\Form\Type\PlayerRegistrationType;
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
        $helper = $this->get('security.authentication_utils');

        return $this->render('main/index.html.twig', [
            'last_error' => $helper->getLastAuthenticationError(),
            'last_username' => $helper->getLastUsername(),
        ]);
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

    /**
     * @Route("/register", name="app_main_register")
     * @Method("GET|POST")
     */
    public function registerAction(Request $request)
    {
        //$contactMessage = new ContactMessage();

        $form = $this->createForm(PlayerRegistrationType::class)
                 ->handleRequest($request)
        ;

        if ($form->isSubmitted() && $form->isValid()) {
            // todo registration => player

            return $this->redirectToRoute('app_main_contact');
        }

        return $this->render('main/register.html.twig', [
            'register_form' => $form->createView(),
        ]);
    }
}
