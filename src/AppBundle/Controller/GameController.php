<?php

namespace AppBundle\Controller;

use AppBundle\Game\GameContext;
use AppBundle\Game\GameRunner;
use AppBundle\Game\Loader\TextFileLoader;
use AppBundle\Game\Loader\XmlFileLoader;
use AppBundle\Game\WordList;
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
        $list = new WordList();
        $list->addLoader('txt', new TextFileLoader());
        $list->addLoader('xml', new XmlFileLoader());

        $list->loadDictionaries([
            $this->getParameter('kernel.root_dir').'/Resources/data/test.txt',
            $this->getParameter('kernel.root_dir').'/Resources/data/words.txt',
            $this->getParameter('kernel.root_dir').'/Resources/data/words.xml',
        ]);

        $context = new GameContext($request->getSession());
        $runner = new GameRunner($context, $list);

        $game = $runner->loadGame();

        return $this->render('game/index.html.twig', [
            'game' => $game,
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
}
