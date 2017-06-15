<?php

namespace AppBundle\Contact;

use AppBundle\Entity\ContactMessage;
use AppBundle\Entity\Player;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class PlayerMailer
{
    private $mailer;
    private $translator;
    private $urlGenerator;
    private $recipient;

    public function __construct(
        \Swift_Mailer $mailer,
        TranslatorInterface $translator,
        UrlGeneratorInterface $urlGenerator,
        $recipient
    ) {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->urlGenerator = $urlGenerator;
        $this->recipient = $recipient;
    }

    public function sendRegistrationConfirmation(Player $player)
    {
        $mail = \Swift_Message::newInstance($this->translator->trans('player.registration.confirmation.subject'))
                 ->setTo($player->getEmail())
                 ->setBcc($this->recipient)
                 ->setFrom('bot@hangman.com', 'Hangman.com')
                 ->setBody($this->translator->trans('player.registration.confirmation.subject', [
                     'username' => $player->getUsername(),
                     'confirmation_link' => $this->urlGenerator->generate(''),
                 ]))
        ;

        $this->mailer->send($mail);
    }
}
