<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\BadgeInterface;
use Badger\GameBundle\Entity\ClaimedBadgeInterface;
use Badger\UserBundle\Entity\UserInterface;

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
     * @param UserInterface  $user
     * @param BadgeInterface $badge
     *
     * @return ClaimedBadgeInterface
     */
    public function create(UserInterface $user, BadgeInterface $badge);
}
