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
     * Return the most unlocked badges (popular ones) for the given $month & $year, only in the given $tag.
     * It sorts them from most to less unlocked.
     *
     * @param string       $month
     * @param string       $year
     * @param TagInterface $tag
     * @param int          $limit
     *
     * @return mixed
     */
    public function getMostUnlockedBadgesForMonth($month, $year, TagInterface $tag, $limit = 3);

    /**
     * Get the top number of badges unlocked for the given $month & $year, only in the given $tag.
     * You can restrict to a specific $user if wanted.
     *
     * It simply returns the top 3 numbers of badges unlock, for example:
     * [4, 2, 1]
     *
     * Which means that someone has 4 unlocks, someone 2 and someone 1.
     * These are the top 3.
     *
     * @param string             $month
     * @param string             $year
     * @param TagInterface       $tag
     * @param null|UserInterface $user
     *
     * @return mixed
     */
    public function getTopNumberOfUnlocksForMonth($month, $year, TagInterface $tag, $user = null);
}
