<?php

namespace Badger\Component\User\Repository;

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
}
