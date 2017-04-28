<?php

namespace AppBundle\Player;

use Symfony\Component\Validator\Constraints as Assert;

class Registration
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(min=3, max=255)
     */
    public $username = '';

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Email
     * @Assert\Length(min=3, max=255)
     */
    public $email = '';

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(min=8)
     */
    public $password = '';
}
