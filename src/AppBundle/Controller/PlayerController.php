<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PlayerRegistrationToken;
use AppBundle\Form\Type\PlayerRegistrationType;
use AppBundle\Player\PlayerEvent;
use AppBundle\Player\PlayerEvents;
use AppBundle\Player\PlayerFactory;
use AppBundle\Player\PlayerManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlayerController extends Controller
{
    /**
     * @Route("/register", name="app_player_register")
     * @Method("GET|POST")
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(PlayerRegistrationType::class, null, [
            'help' => 'Toto',
        ])
                     ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $player = $this->get(PlayerFactory::class)->createPlayer($form->getData());

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($player);
            $manager->flush();

            $this->addFlash('success', 'player.register.success');
            $this->get('event_dispatcher')->dispatch(PlayerEvents::REGISTRATION, new PlayerEvent($player));

            return $this->redirectToRoute('app_main_index');
        }

        return $this->render('player/register.html.twig', [
            'register_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/confirmation/{token}", name="app_player_register_confirmation")
     * @Method("GET")
     */
    public function registerConfirmationAction(Request $request, $token)
    {
        $this->get(PlayerManager::class)->confirmRegistration($token);

        $this->addFlash('success', 'toto');

        return $this->redirectToRoute('app_game_index');
    }
}
