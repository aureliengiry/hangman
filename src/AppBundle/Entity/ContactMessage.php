<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class ContactMessage
{
    private const MAX_ATTACHMENTS_SIZE = 8 * 1024 * 1024;

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

    /**
     * @Assert\File
     */
    private $file1 = '';

    /**
     * @Assert\File
     */
    private $file2 = '';

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

    /**
     * @Assert\IsTrue(message="toto")
     */
    public function isAttachmentsSizeValid()
    {
        $totalSize = 0;

        if ($this->file1 instanceof File) {
            $totalSize += $this->file1->getSize();
        }
        if ($this->file2 instanceof File) {
            $totalSize += $this->file2->getSize();
        }

        return $totalSize < self::MAX_ATTACHMENTS_SIZE;
    }
}
