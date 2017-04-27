<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ContactMessage
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $senderName = '';

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $senderEmail = '';

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=10, max=1000)
     */
    private $content = '';

    public function getSenderName()
    {
        return $this->senderName;
    }

    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
    }

    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    public function setSenderEmail($senderEmail)
    {
        $this->senderEmail = $senderEmail;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}
