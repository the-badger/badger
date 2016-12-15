<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\BadgeInterface;
use Badger\GameBundle\Entity\UnlockedBadge;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author  Adrien Pétremann <adrien.petremann@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface UnlockedBadgeFactoryInterface
{
    /**
     * Create an UnlockedBadge instance from a given $user and $badge.
     *
     * @param UserInterface  $user
     * @param BadgeInterface $badge
     *
     * @return UnlockedBadge
     */
    public function create(UserInterface $user, BadgeInterface $badge);
}
