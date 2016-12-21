<?php

namespace spec\Badger\Bundle\GameBundle\EventListener;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\Game\Model\UnlockedBadgeInterface;
use Badger\Bundle\GameBundle\Event\BadgeUnlockEvent;
use Badger\Component\Game\Notifier\NotifierInterface;
use Badger\Component\User\Model\UserInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class UnlockBadgeListenerSpec extends ObjectBehavior
{
    function let(Router $router, Logger $logger, NotifierInterface $notifier)
    {
        $this->beConstructedWith($router, $logger, $notifier);
    }

    function it_notifies_on_badge_unlock(
        $router,
        $notifier,
        BadgeUnlockEvent $event,
        UnlockedBadgeInterface $unlockedBadge,
        BadgeInterface $badge,
        UserInterface $user
    ) {
        $user->getUsername()->willReturn('Bender');

        $badge->getId()->willReturn('aef42');
        $badge->getTitle()->willReturn('The Best Robot');
        $badge->getDescription()->willReturn('You are, indeed, the best robot.');
        $badge->getImageWebPath()->willReturn('uploads/game/image.png');

        $unlockedBadge->getUser()->willReturn($user);
        $unlockedBadge->getBadge()->willReturn($badge);

        $event->getUnlockedBadge()->willReturn($unlockedBadge);

        $router->generate('userprofile', ['username' => 'Bender'], 0)->willReturn(
            'http://mybadger.example/user/Bender'
        );
        $router->generate('viewbadge', ['id' => 'aef42'], 0)->willReturn(
            'http://mybadger.example/badge/aef42'
        );
        $router->generate('homepage', [], 0)->willReturn(
            'http://mybadger.example/'
        );

        $expected = [
            'text' => '<http://mybadger.example/user/Bender|Bender> just unlocked the badge <http://mybadger.example/badge/aef42|The Best Robot>!',
            'attachments' => [
                [
                    'color' => 'good',
                    'title' => 'The Best Robot',
                    'text' => 'You are, indeed, the best robot.',
                    'thumb_url' => 'http://mybadger.example/uploads/game/image.png'
                ]
            ]
        ];

        $notifier->notify($expected)->shouldBeCalled();

        $this->onUnlockBadge($event);
    }
}
