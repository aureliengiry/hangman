<?php

namespace Tests\AppBundle\Game;

use AppBundle\Game\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * @dataProvider provideWords
     */
    public function testGetContext($word)
    {
        $game = new Game($word, '0');

        $expectedContext = static::getSimpleContext('toto');

        $this->assertSame($expectedContext, $game->getContext(), 'The context was wrongly initialized.');
    }

    public function provideWords()
    {
        yield ['toto'];
        yield ['TOTO'];
        yield ['ToTo'];
    }

    public static function getSimpleContext($word, $attempts = 0)
    {
        return [
            'word' => $word,
            'attempts' => $attempts,
            'found_letters' => [],
            'tried_letters' => [],
        ];
    }
}
