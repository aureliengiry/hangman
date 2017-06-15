<?php

namespace AppBundle\Player;

use AppBundle\Entity\Player;
use Symfony\Component\EventDispatcher\Event;

class PlayerEvent extends Event
{
    private $player;

    function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function getPlayer()
    {
        return $this->player;
    }
}
