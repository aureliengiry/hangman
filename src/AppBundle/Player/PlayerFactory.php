<?php

namespace AppBundle\Player;

use AppBundle\Entity\Player;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class PlayerFactory
{
    private $encoder;

    function __construct(PasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param Registration $registration
     *
     * @return Player
     */
    public function createPlayer(Registration $registration)
    {
        $password = $this->encoder->encodePassword($registration->password, '');

        return new Player($registration->username, $password, $registration->email);
    }
}
