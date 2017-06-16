<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 */
class Player implements UserInterface
{
    use Traits\IdentityTrait;

    /**
     * @ORM\Column
     */
    private $username;

    /**
     * @ORM\Column
     */
    private $password;

    /**
     * @ORM\Column
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity="PlayerRegistrationToken", mappedBy="player", cascade={"persist"})
     */
    private $registrationToken;

    /**
     * @ORM\Column(type="boolean", options={"default"=false})
     */
    private $activated = false;

    /**
     * @ORM\Column(type="smallint", options={"default"=0})
     */
    private $gamesCount = 0;

    public function __construct($username, $password, $email, PlayerRegistrationToken $token)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->registrationToken = $token;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return ['ROLE_PLAYER'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return PlayerRegistrationToken
     */
    public function getRegistrationToken()
    {
        return $this->registrationToken;
    }

    public function confirm()
    {
        $this->activated = true;
        $this->registrationToken = null;
    }

    public function increaseGamesCount()
    {
        ++$this->gamesCount;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }
}
