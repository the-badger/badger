<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Badge;
use Badger\GameBundle\Entity\UnlockedBadge;
use Badger\UserBundle\Entity\User;

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
