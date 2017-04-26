<?php

namespace AppBundle\Controller;

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
        $form = $this->createForm(ContactType::class)
                     ->handleRequest($request)
        ;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $message = \Swift_Message::newInstance($this->get('translator')->trans('contact.subject'))
                ->setTo($this->getParameter('webmaster_mail'))
                ->setFrom($data['email'], $data['name'])
                ->setBody($data['content'])
            ;

            $this->get('mailer')->send($message);

            return $this->redirectToRoute('app_main_contact');
        }

        return $this->render('main/contact.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}
