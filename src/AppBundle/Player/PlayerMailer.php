<?php

namespace AppBundle\Player;

use AppBundle\Entity\Player;
use AppBundle\Mailer\AbstractMailer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class PlayerMailer extends AbstractMailer
{
    private $urlGenerator;

    public function __construct(
        \Swift_Mailer $mailer,
        TranslatorInterface $translator,
        $recipient,
        UrlGeneratorInterface $urlGenerator
    ) {
        parent::__construct($mailer, $translator, $recipient);

        $this->urlGenerator = $urlGenerator;

    }

    public function sendRegistrationConfirmation(Player $player)
    {
        $mail = \Swift_Message::newInstance($this->translator->trans('player.registration.confirmation.subject'))
                 ->setTo($player->getEmail())
                 ->setBcc($this->recipient)
                 ->setFrom('bot@hangman.com', 'Hangman.com')
                 ->setBody($this->translator->trans('player.registration.confirmation.subject', [
                     'username' => $player->getUsername(),
                     'confirmation_link' => $this->urlGenerator->generate('app_player_register_confirmation', [
                         'token' => $player->getRegistrationToken(),
                     ]),
                 ]))
        ;

        $this->mailer->send($mail);
    }
}
