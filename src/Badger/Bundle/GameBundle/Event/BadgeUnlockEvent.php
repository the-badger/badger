<?php

namespace Badger\Bundle\GameBundle\Event;

use Badger\Component\Game\Model\UnlockedBadgeInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * This event is dispatched when a User unlocked a Badge.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class BadgeUnlockEvent extends Event
{
    /** @var UnlockedBadgeInterface */
    protected $unlockedBadge;

    /**
     * @param UnlockedBadgeInterface $unlockedBadge
     */
    public function __construct(UnlockedBadgeInterface $unlockedBadge)
    {
        $this->unlockedBadge = $unlockedBadge;
    }

    /**
     * @return UnlockedBadgeInterface
     */
    public function getUnlockedBadge()
    {
        return $this->unlockedBadge;
    }
}
