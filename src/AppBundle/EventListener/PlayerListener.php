<?php

namespace AppBundle\EventListener;

use AppBundle\Player\PlayerEvents;
use AppBundle\Player\PlayerMailer;
use AppBundle\Player\PlayerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PlayerListener implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(PlayerMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            PlayerEvents::REGISTRATION => 'onPlayerRegistering',
        ];
    }

    public function onPlayerRegistering(PlayerEvent $event)
    {
        $this->mailer->sendRegistrationConfirmation($event->getPlayer());
    }
}
