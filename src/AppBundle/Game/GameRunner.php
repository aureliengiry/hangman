<?php

namespace AppBundle\Game;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GameRunner
{
    /**
     * The Game context.
     *
     * @var GameContextInterface
     */
    private $context;

    /**
     * The list of words.
     *
     * @var WordListInterface
     */
    private $wordList;

    private $dispatcher;

    private $tokenStorage;

    /**
     * Constructor.
     *
     * @param GameContextInterface $context
     * @param WordListInterface    $wordList
     */
    public function __construct(
        GameContextInterface $context,
        WordListInterface $wordList = null,
        EventDispatcherInterface $eventDispatcher,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->context = $context;
        $this->wordList = $wordList;
        $this->dispatcher = $eventDispatcher;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Loads the current game or creates a new one.
     *
     * @param int $length The word length to guess
     *
     * @return Game
     */
    public function loadGame($length = 8)
    {
        if ($game = $this->context->loadGame()) {
            return $game;
        }

        if (!$this->wordList) {
            throw new \RuntimeException('A WordListInterface instance must be set.');
        }

        $word = $this->wordList->getRandomWord($length);
        $game = $this->context->newGame($word);
        $this->context->save($game);
        $this->dispatch(GameEvents::START, $game);


        return $game;
    }

    /**
     * Tests the given letter against the current game.
     *
     * @param string $letter An alpha character from "a" to "z"
     *
     * @return Game
     * @throws NotFoundHttpException
     */
    public function playLetter($letter)
    {
        if (!$game = $this->context->loadGame()) {
            throw $this->createNotFoundException('No game context set.');
        }

        $game->tryLetter($letter);
        $this->context->save($game);

        return $game;
    }

    /**
     * Tests the given word against the current game.
     *
     * @param string $word
     *
     * @return Game
     * @throws NotFoundHttpException
     */
    public function playWord($word)
    {
        if (!$game = $this->context->loadGame()) {
            throw $this->createNotFoundException('No game context set.');
        }

        $game->tryWord($word);
        $this->context->save($game);

        return $game;
    }

    public function resetGame(\Closure $onStatusCallback = null)
    {
        if (!$game = $this->context->loadGame()) {
            throw $this->createNotFoundException('No game context set.');
        }

        // Custom logic on failure or on success
        // thanks to an anonymous function
        if ($onStatusCallback) {
            call_user_func_array($onStatusCallback, [ $game ]);
        }

        $this->context->reset();

        $this->dispatch(GameEvents::OVER, $game);

        return $game;
    }

    public function resetGameOnSuccess()
    {
        $onWonGame = function (Game $game) {
            if (!$game->isOver()) {
                throw $this->createNotFoundException('Current game is not yet over.');
            }

            if (!$game->isWon()) {
                throw $this->createNotFoundException('Current game must be won.');
            }

            $this->dispatch(GameEvents::WON, $game);
        };

        return $this->resetGame($onWonGame);
    }

    public function resetGameOnFailure()
    {
        $onLostGame = function (Game $game) {
            if (!$game->isOver()) {
                throw $this->createNotFoundException('Current game is not yet over.');
            }

            if (!$game->isHanged()) {
                throw $this->createNotFoundException('Current game must be lost.');
            }

            $this->dispatch(GameEvents::FAILED, $game);
        };

        return $this->resetGame($onLostGame);
    }

    private function createNotFoundException($message)
    {
        return new NotFoundHttpException($message);
    }

    private function dispatch($eventName, $game)
    {
        $this->dispatcher->dispatch($eventName, new GameEvent(
            $this->tokenStorage->getToken()->getUser(),
            $game
        ));
    }
}
