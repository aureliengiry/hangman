<?php

namespace AppBundle\Controller;

use AppBundle\Game\GameRunner;
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
     * @Security("has_role('ROLE_PLAYER') and is_granted('CAN_PLAY')")
     */
    public function indexAction()
    {
        return $this->render('game/index.html.twig', [
            'game' => $this->get(GameRunner::class)->loadGame(),
        ]);
    }

    /**
     * @Route("/won", name="app_game_won")
     * @Method("GET")
     */
    public function wonAction()
    {
        return $this->render('game/won.html.twig', [
            'game' => $this->get(GameRunner::class)->resetGameOnSuccess()
        ]);
    }

    /**
     * @Route("/failed", name="app_game_failed")
     * @Method("GET")
     */
    public function failedAction()
    {
        return $this->render('game/failed.html.twig', [
            'game' => $this->get(GameRunner::class)->resetGameOnFailure()
        ]);
    }

    /**
     * @Route("/reset", name="app_game_reset")
     * @Method("GET")
     */
    public function resetAction()
    {
        $this->get(GameRunner::class)->resetGame();

        return $this->redirectToRoute('app_game_index');
    }

    /**
     * @Route("/letter/{letter}", name="app_game_play_letter", requirements={"letter": "[a-zA-Z]"})
     * @Method("GET")
     */
    public function playLetterAction($letter, Request $request)
    {
        $game = $this->get(GameRunner::class)->playLetter($letter);

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
        $game = $this->get(GameRunner::class)->playWord($word);

        if ($game->isWon()) {
            return $this->redirectToRoute('app_game_won');
        }

        if ($game->isHanged()) {
            return $this->redirectToRoute('app_game_failed');
        }

        return $this->redirectToRoute('app_game_index');
    }
}
