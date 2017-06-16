<?php

namespace AppBundle\Security;

use AppBundle\Entity\Player;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class GameVoter extends Voter
{
    const CAN_PLAY = 'CAN_PLAY';

    private $gameLimit;

    public function __construct($gameLimit)
    {
        $this->gameLimit = $gameLimit;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        return $attribute === self::CAN_PLAY;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string         $attribute
     * @param mixed          $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $player = $token->getUser();

        if (!$player instanceof UserInterface) {
            return false;
        }

        if ($player instanceof Player) {
            return $player->getGamesCount() < $this->gameLimit;
        }

        return true;
    }
}
