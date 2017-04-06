<?php

namespace Badger\Component\Game\Unlocker;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\User\Model\UserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
