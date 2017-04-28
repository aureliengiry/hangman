<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/game")
 * @Security("has_role('ROLE_PLAYER')")
 */
class GameController extends Controller
{
    /**
     * @Route(name="app_game_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('game/index.html.twig', [
            'game' => $this->get('app.game.game_runner')->loadGame(),
        ]);
    }

    /**
     * @Route("/won", name="app_game_won")
     */
    public function wonAction()
    {
        return $this->render('game/won.html.twig', [
            'game' => $this->get('app.game.game_runner')->resetGameOnSuccess()
        ]);
    }

    /**
     * @Route("/failed", name="app_game_failed")
     */
    public function failedAction()
    {
        return $this->render('game/failed.html.twig', [
            'game' => $this->get('app.game.game_runner')->resetGameOnFailure()
        ]);
    }

    /**
     * @Route("/reset", name="app_game_reset")
     * @Method("GET")
     */
    public function resetAction()
    {
        $this->get('app.game.game_runner')->resetGame();

        return $this->redirectToRoute('app_game_index');
    }

    /**
     * @Route("/letter/{letter}", name="app_game_play_letter", requirements={"letter": "[a-zA-Z]"})
     * @Method("GET")
     */
    public function playLetterAction($letter, Request $request)
    {
        $game = $this->get('app.game.game_runner')->playLetter($letter);

        if ($game->isWon()) {
            return $this->redirectToRoute('app_game_won');
        }

        if ($game->isHanged()) {
            return $this->redirectToRoute('app_game_failed');
        }

        return $this->redirectToRoute('app_game_index');
    }

    /**
     * @Route("/word", name="app_game_play_word")
     * @Method("POST")
     */
    public function playWordAction(Request $request)
    {
        $word = $request->request->getAlpha('word');
        $game = $this->get('app.game.game_runner')->playWord($word);

        if ($game->isWon()) {
            return $this->redirectToRoute('app_game_won');
        }

        if ($game->isHanged()) {
            return $this->redirectToRoute('app_game_failed');
        }

        return $this->redirectToRoute('app_game_index');
    }
}
