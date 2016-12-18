<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\BadgeInterface;
use Badger\GameBundle\Entity\ClaimedBadgeInterface;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
