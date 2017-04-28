<?php

namespace AppBundle\Contact;

use AppBundle\Entity\ContactMessage;
use Symfony\Component\Translation\TranslatorInterface;

class ContactMailer
{
    private $mailer;
    private $translator;
    private $recipient;

    public function __construct(\Swift_Mailer $mailer, TranslatorInterface $translator, $recipient)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->recipient = $recipient;
    }

    public function sendMessage(ContactMessage $message)
    {
        $mail = \Swift_Message::newInstance($this->translator->trans('contact.subject'))
                 ->setTo($this->recipient)
                 ->setFrom($message->getSenderEmail(), $message->getSenderName())
                 ->setBody($message->getContent())
        ;

        $this->mailer->send($mail);
    }
}
