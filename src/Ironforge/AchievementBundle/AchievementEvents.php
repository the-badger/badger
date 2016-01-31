<?php

namespace Ironforge\AchievementBundle;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AchievementEvents
{
    /**
     * The achievement.user_unlocks_badge event is thrown each time a user unlocked
     * a new badge.
     *
     * The event listener receives an
     * Ironforge\AchievementBundle\Event\BadgeUnlockEvent
     *
     * @var string
     */
    const USER_UNLOCKS_BADGE = 'achievement.user_unlocks_badge';
}
