<?php

namespace Tests\AppBundle\Game;

use AppBundle\Game\Game;
use AppBundle\Game\GameContext;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameContextTest extends TestCase
{
    public function testLoadGameReturnsFalse()
    {
        $session = $this->createMock(SessionInterface::class);
        $session
            ->expects($this->once())
            ->method('get')
            ->willReturn([])
        ;

        $context = new GameContext($session);

        $this->assertFalse($context->loadGame());
    }

    public function testLoadGameReturnsGame()
    {
        $expectedContext = GameTest::getSimpleContext('toto');

        $session = $this->createMock(SessionInterface::class);
        $session
            ->expects($this->once())
            ->method('get')
            ->willReturn($expectedContext)
        ;

        $context = new GameContext($session);

        $expectedGame = new Game(
            $expectedContext['word'],
            $expectedContext['attempts']
        );

        $this->assertEquals($expectedGame, $context->loadGame());
    }
}
