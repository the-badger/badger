<?php

namespace Badger\Component\User\Repository;

use Badger\Component\Game\Model\TagInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface UserRepositoryInterface
{
    /**
     * @return int
     */
    public function countAll();

    /**
     * @param string $order
     * @param int    $limit
     *
     * @return array
     */
    public function getSortedUserByUnlockedBadges($order = 'DESC', $limit = 7);

    /**
     * @return array
     */
    public function getAllUsernames();

    /**
     * Return all new users for the given month and year of $date.
     *
     * @param \DateTime $date
     *
     * @return array
     */
    public function getNewUsersForMonth(\DateTime $date);

    /**
     * Return the user who unlocked the most badges for given month and year of $date, in the given $tag.
     * $nbOfBadges is an array, with number of badges of the podium. Example:
     *
     * getMonthlyBadgeChampions('02', '1990', $tag, [4, 2, 1]) =>
     * 4 badges: John, Lannister
     * 2 badges: Mary, Ulric
     * 1 badge: Thrall
     *
     * @param \DateTime    $date
     * @param TagInterface $tag
     * @param array        $nbOfBadges
     *
     * @return mixed
     */
    public function getMonthlyBadgeChampions(\DateTime $date, TagInterface $tag, array $nbOfBadges);
}
