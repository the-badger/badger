<?php

namespace Badger\Bundle\GameBundle\Event;

use Badger\Component\Game\Model\BadgeCompletionInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * This event is dispatched when a User unlocked a Badge.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class BadgeUnlockEvent extends Event
{
    /** @var BadgeCompletionInterface */
    protected $badgeCompletion;

    /**
     * @param BadgeCompletionInterface $badgeCompletion
     */
    public function __construct(BadgeCompletionInterface $badgeCompletion)
    {
        $this->badgeCompletion = $badgeCompletion;
    }

    /**
     * @return BadgeCompletionInterface
     */
    public function getBadgeCompletion()
    {
        return $this->badgeCompletion;
    }
}
