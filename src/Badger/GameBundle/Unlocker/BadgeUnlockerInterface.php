<?php

namespace Badger\GameBundle\Unlocker;

use Badger\GameBundle\Entity\BadgeInterface;
use Badger\GameBundle\Entity\ClaimedBadgeInterface;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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

    /**
     * Use the given $claimedBadge to unlock a badge for the user that claimed it.
     * It removes the claimed badge when done.
     *
     * @param ClaimedBadgeInterface $claimedBadge
     */
    public function unlockBadgeFromClaim(ClaimedBadgeInterface $claimedBadge);
}
