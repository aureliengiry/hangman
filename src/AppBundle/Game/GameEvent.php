<?php

namespace AppBundle\Game;

use AppBundle\Entity\Player;
use AppBundle\Player\PlayerEvent;

class GameEvent extends PlayerEvent
{
    private $game;

    public function __construct(Player $player, Game $game)
    {
        $this->game = $game;

        parent::__construct($player);
    }

    public function getGame(): Game
    {
        return $this->game;
    }
}
