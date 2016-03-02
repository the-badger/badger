<?php

namespace Ironforge\AchievementBundle\Factory;

use Ironforge\AchievementBundle\Entity\Badge;
use Ironforge\AchievementBundle\Entity\UnlockedBadge;
use Ironforge\UserBundle\Entity\User;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
interface UnlockedBadgeFactoryInterface
{
    /**
     * Create an UnlockedBadge instance from a given $user and $badge.
     *
     * @param User  $user
     * @param Badge $badge
     *
     * @return UnlockedBadge
     */
    public function create(User $user, Badge $badge);
}
