<?php

namespace Ironforge\AchievementBundle\Event;

use Ironforge\AchievementBundle\Entity\UnlockedBadge;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class BadgeUnlockEvent extends Event
{
    protected $unlockedBadge;

    public function __construct(UnlockedBadge $unlockedBadge)
    {
        $this->unlockedBadge = $unlockedBadge;
    }

    public function getUnlockedBadge()
    {
        return $this->unlockedBadge;
    }
}
