<?php

namespace Ironforge\AchievementBundle\EventListener;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Ironforge\AchievementBundle\Event\BadgeUnlockEvent;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class UnlockBadgeListener
{
    /** @var Router */
    private $router;

    /** @var Logger */
    private $logger;

    /** @var string */
    private $webhookUrl;

    public function __construct(Router $router, Logger $logger, $webhookUrl)
    {
        $this->router     = $router;
        $this->logger     = $logger;
        $this->webhookUrl = $webhookUrl;
    }

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

        $client = new Client();
        $request = new Request(
            'POST',
            $this->webhookUrl,
            ['Content-type' => 'application/json'],
            json_encode($data)
        );

        $response = $client->send($request, ['timeout' => 2]);

        $this->logger->debug('ADRIEN= '. json_encode($data));
    }
}
