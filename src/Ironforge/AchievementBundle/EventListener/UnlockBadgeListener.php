<?php

namespace Ironforge\AchievementBundle\EventListener;

use Ironforge\AchievementBundle\Event\BadgeUnlockEvent;
use Ironforge\AchievementBundle\Notifier\NotifierInterface;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author Adrien Pétremann <petremann.adrien@gmail.com>
 */
class UnlockBadgeListener
{
    /** @var Router */
    private $router;

    /** @var Logger */
    private $logger;

    /** @var NotifierInterface */
    private $notifier;

    /**
     * @param Router            $router
     * @param Logger            $logger
     * @param NotifierInterface $notifier
     */
    public function __construct(Router $router, Logger $logger, NotifierInterface $notifier)
    {
        $this->router   = $router;
        $this->logger   = $logger;
        $this->notifier = $notifier;
    }

    /**
     * @param BadgeUnlockEvent $event
     */
    public function onUnlockBadge(BadgeUnlockEvent $event)
    {
        $unlockedBadge = $event->getUnlockedBadge();
        $user = $unlockedBadge->getUser();
        $badge = $unlockedBadge->getBadge();

        $data = [
            'text' => sprintf(
                '<%s|%s> just unlocked the badge <%s|%s>!',
                $this->router->generate(
                    'userprofile',
                    ['username' => $user->getUsername()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                $user->getUsername(),
                $this->router->generate(
                    'viewbadge',
                    ['id' => $badge->getId()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                $badge->getTitle()
            ),
            'attachments' => [
                [
                    'color' => 'good',
                    'title' => $badge->getTitle(),
                    'text' => $badge->getDescription(),
                    'thumb_url' => $this->router->generate(
                        'homepage',
                        [],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    ) . $badge->getImageWebPath()
                ]
            ]
        ];

        $this->notifier->notify($data);
    }
}
