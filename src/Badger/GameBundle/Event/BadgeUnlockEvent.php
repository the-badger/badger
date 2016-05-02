<?php

namespace Badger\GameBundle\Event;

use Badger\GameBundle\Entity\UnlockedBadge;
use Symfony\Component\EventDispatcher\Event;

/**
 * This event is dispatched when a User unlocked a Badge.
 *
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeUnlockEvent extends Event
{
    /** @var UnlockedBadge */
    protected $unlockedBadge;

    /**
     * @param UnlockedBadge $unlockedBadge
     */
    public function __construct(UnlockedBadge $unlockedBadge)
    {
        $this->unlockedBadge = $unlockedBadge;
    }

    /**
     * @return UnlockedBadge
     */
    public function getUnlockedBadge()
    {
        return $this->unlockedBadge;
    }
}
