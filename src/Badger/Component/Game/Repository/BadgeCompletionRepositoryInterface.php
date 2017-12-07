<?php

namespace Badger\Component\Game\Repository;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\Game\Model\TagInterface;
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

    /**
     * Return the most unlocked badges (popular ones) for the given month and year of $date, only in the given $tag.
     * It sorts them from most to less unlocked.
     *
     * @param \DateTime    $date
     * @param TagInterface $tag
     * @param int          $limit
     *
     * @return mixed
     */
    public function getMostUnlockedBadgesForDate(\DateTime $date, TagInterface $tag, $limit = 3);

    /**
     * Return the most unlocked badges (popular ones) only in the given $tag.
     * It sorts them from most to less unlocked.
     *
     * @param TagInterface $tag
     * @param int          $limit
     *
     * @return mixed
     */
    public function getTopNumberOfUnlocks(TagInterface $tag, $limit = 10);

    /**
     * Get the top number of badges unlocked for the given month and year of $date, only in the given $tag.
     * You can restrict to a specific $user if wanted.
     *
     * It simply returns the top 3 numbers of badges unlock, for example:
     * [4, 2, 1]
     *
     * Which means that someone has 4 unlocks, someone 2 and someone 1.
     * These are the top 3.
     *
     * @param \DateTime          $date
     * @param TagInterface       $tag
     * @param null|UserInterface $user
     *
     * @return mixed
     */
    public function getTopNumberOfUnlocksForDate(\DateTime $date, TagInterface $tag, $user = null);
}
