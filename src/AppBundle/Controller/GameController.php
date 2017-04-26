<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GameController extends Controller
{
    /**
     * @Route("/game", name="app_game_index")
     */
    public function indexAction(Request $request)
    {
        return $this->render('game/index.html.twig');
    }

    /**
     * @Route("/game/won", name="app_game_won")
     */
    public function wonAction(Request $request)
    {
        return $this->render('game/won.html.twig');
    }

    /**
     * @Route("/game/failed", name="app_game_failed")
     */
    public function failedAction(Request $request)
    {
        return $this->render('game/failed.html.twig');
    }
}
