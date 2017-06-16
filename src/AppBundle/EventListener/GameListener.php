<?php

namespace AppBundle\EventListener;

use AppBundle\Game\GameEvent;
use AppBundle\Game\GameEvents;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GameListener implements EventSubscriberInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            GameEvents::OVER => 'onGameOver',
        ];
    }

    public function onGameOver(GameEvent $event)
    {
        $event->getPlayer()->increaseGamesCount();

        $this->manager->flush();
    }
}
