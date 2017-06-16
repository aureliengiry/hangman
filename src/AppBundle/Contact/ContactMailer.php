<?php

namespace AppBundle\Contact;

use AppBundle\Entity\ContactMessage;
use AppBundle\Mailer\AbstractMailer;
use Symfony\Component\Translation\TranslatorInterface;

class ContactMailer extends AbstractMailer
{
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
