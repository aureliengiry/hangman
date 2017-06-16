<?php

namespace AppBundle\Game;

class GameEvents
{
    /**
     * @Event("AppBundle\Game\GameEvent")
     */
    const START = 'game.start';

    /**
     * @Event("AppBundle\Game\GameEvent")
     */
    const OVER = 'game.over';

    /**
     * @Event("AppBundle\Game\GameEvent")
     */
    const WON = 'game.won';

    /**
     * @Event("AppBundle\Game\GameEvent")
     */
    const FAILED = 'game.failed';

    /**
     * This class should not be instantiated.
     */
    private function __construct()
    {
    }
}
