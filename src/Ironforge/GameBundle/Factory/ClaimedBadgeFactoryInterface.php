<?php

namespace Ironforge\GameBundle\Factory;

use Ironforge\GameBundle\Entity\Badge;
use Ironforge\GameBundle\Entity\ClaimedBadge;
use Ironforge\UserBundle\Entity\User;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
interface ClaimedBadgeFactoryInterface
{
    /**
     * Create a ClaimedBadge instance from a given $user and $badge.
     *
     * @param User  $user
     * @param Badge $badge
     *
     * @return ClaimedBadge
     */
    public function create(User $user, Badge $badge);
}
