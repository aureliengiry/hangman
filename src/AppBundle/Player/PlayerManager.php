<?php

namespace AppBundle\Player;

use AppBundle\Entity\PlayerRegistrationToken;
use AppBundle\Exception\PlayerRegistrationTokenNotFoundException;
use AppBundle\Repository\PlayerRegistrationTokenRepository;
use Doctrine\Common\Persistence\ObjectManager;

class PlayerManager
{
    private $registrationTokenRepository;
    private $manager;

    public function __construct(
        PlayerRegistrationTokenRepository $registrationTokenRepository,
        ObjectManager $manager
    ) {
        $this->registrationTokenRepository = $registrationTokenRepository;
        $this->manager = $manager;
    }

    public function confirmRegistration($tokenValue)
    {
        $token = $this->registrationTokenRepository->findOneBy(['value' => $tokenValue]);

        if (!$token instanceof PlayerRegistrationToken) {
            throw new PlayerRegistrationTokenNotFoundException($tokenValue);
        }

        $token->activate();
        $this->manager->flush();
    }
}
