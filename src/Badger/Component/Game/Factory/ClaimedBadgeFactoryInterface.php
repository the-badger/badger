<?php

namespace Badger\Component\Game\Factory;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\Game\Model\ClaimedBadgeInterface;
use Badger\Component\User\Model\UserInterface;

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
