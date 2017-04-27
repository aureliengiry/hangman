<?php

namespace AppBundle\Controller;

use AppBundle\Game\GameContext;
use AppBundle\Game\GameRunner;
use AppBundle\Game\Loader\TextFileLoader;
use AppBundle\Game\Loader\XmlFileLoader;
use AppBundle\Game\WordList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends Controller
{
    /**
     * @Route("/game", name="app_game_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $runner = $this->getRunner($request->getSession());

        return $this->render('game/index.html.twig', [
            'game' => $runner->loadGame(),
        ]);
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

    /**
     * @Route("/game/reset", name="app_game_reset")
     * @Method("GET")
     */
    public function resetAction(Request $request)
    {
        $this->getRunner($request->getSession())->resetGame();

        return $this->redirectToRoute('app_game_index');
    }

    /**
     * @Route("/game/letter/{letter}", name="app_game_play_letter", requirements={"letter": "[a-zA-Z]"})
     * @Method("GET")
     */
    public function playLetterAction($letter, Request $request)
    {
        $game = $this->getRunner($request->getSession())->playLetter($letter);

        if ($game->isWon()) {
            return $this->redirectToRoute('app_game_won');
        }

        if ($game->isHanged()) {
            return $this->redirectToRoute('app_game_failed');
        }

        return $this->redirectToRoute('app_game_index');
    }

    /**
     * @Route("/game/word", name="app_game_play_word")
     * @Method("POST")
     */
    public function playWordAction(Request $request)
    {
        $word = $request->request->getAlpha('word');
        $game = $this->getRunner($request->getSession())->playWord($word);

        if ($game->isWon()) {
            return $this->redirectToRoute('app_game_won');
        }

        if ($game->isHanged()) {
            return $this->redirectToRoute('app_game_failed');
        }

        return $this->redirectToRoute('app_game_index');
    }

    /**
     * @param SessionInterface $session
     *
     * @return GameRunner
     */
    private function getRunner(SessionInterface $session)
    {
        $list = new WordList();
        $list->addLoader('txt', new TextFileLoader());
        $list->addLoader('xml', new XmlFileLoader());

        $list->loadDictionaries([
            $this->getParameter('kernel.root_dir').'/Resources/data/test.txt',
            $this->getParameter('kernel.root_dir').'/Resources/data/words.txt',
            $this->getParameter('kernel.root_dir').'/Resources/data/words.xml',
        ]);

        $context = new GameContext($session);

        return new GameRunner($context, $list);
    }
}
