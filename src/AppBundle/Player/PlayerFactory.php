<?php

namespace AppBundle\Player;

use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerRegistrationToken;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class PlayerFactory
{
    private $encoder;

    public function __construct(PasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param Registration $registration
     * @param string       $registrationExpiration
     *
     * @return Player
     */
    public function createPlayer(Registration $registration, $registrationExpiration = '+1 day')
    {
        $password = $this->encoder->encodePassword($registration->password, '');

        return new Player($registration->username, $password, $registration->email, new PlayerRegistrationToken($registrationExpiration));
    }
}
