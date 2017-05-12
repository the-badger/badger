<?php

namespace Badger\Component\Game\Repository;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\User\Model\UserInterface;


/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface BadgeCompletionRepositoryInterface
{
    /**
     * Get all completion badges for the given $user.
     *
     * @param UserInterface $user
     * @param bool|null     $pending Precise only unlocked or only pending. Leave empty for both.
     *
     * @return array
     */
    public function getCompletionBadgesByUser(UserInterface $user, $pending = null);

    /**
     * Return whether the given $user has the given $badge.
     *
     * @param UserInterface  $user
     * @param BadgeInterface $badge
     *
     * @return bool
     */
    public function userHasBadge(UserInterface $user, BadgeInterface $badge);
}
