<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdentityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlayerRegistrationTokenRepository")
 */
class PlayerRegistrationToken
{
    use IdentityTrait;

    /**
     * @var string
     *
     * @ORM\Column
     */
    private $value;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetime")
     */
    private $expirationDate;

    /**
     * @var Player
     *
     * @ORM\OneToOne(targetEntity="Player", inversedBy="registrationToken", fetch="EAGER")
     */
    private $player;

    public function __construct($expirationDate = '+1 day')
    {
        $this->value = uniqid(mt_rand());
        $this->expirationDate = new \DateTimeImmutable($expirationDate);
    }

    public function __toString()
    {
        return $this->value;
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function setPlayer(Player $player)
    {
        $this->player = $player;
    }

    public function activate()
    {
        return $this->player->confirm();
    }
}
