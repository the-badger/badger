<?php

namespace Badger\Component\Game\Unlocker;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\User\Model\UserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface BadgeUnlockerInterface
{
    /**
     * Unlock the given $badge for the given $user.
     *
     * @param UserInterface  $user
     * @param BadgeInterface $badge
     */
    public function unlockBadge(UserInterface $user, BadgeInterface $badge);
}
