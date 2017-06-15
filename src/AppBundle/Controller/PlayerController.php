<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\PlayerRegistrationType;
use AppBundle\Player\PlayerFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;

class PlayerController extends Controller
{
    /**
     * @Route("/register", name="app_main_register")
     * @Method("GET|POST")
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(PlayerRegistrationType::class)
                     ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $player = $this->get(PlayerFactory::class)->createPlayer($form->getData());

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($player);
            $manager->flush();

            $this->addFlash('success', 'player.register.success');
            $this->get('event_dispatcher')->dispatch('player.registration', new GenericEvent($player));

            return $this->redirectToRoute('app_main_index');
        }

        return $this->render('main/register.html.twig', [
            'register_form' => $form->createView(),
        ]);
    }
}
