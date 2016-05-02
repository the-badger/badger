<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Badge;
use Badger\GameBundle\Entity\ClaimedBadge;
use Badger\UserBundle\Entity\User;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
