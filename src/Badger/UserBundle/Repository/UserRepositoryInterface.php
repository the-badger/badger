<?php

namespace Badger\UserBundle\Repository;

/**
 * @author  Adrien Pétremann <adrien.petremann@akeneo.com>
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
     * @return int
     */
    public function getSortedUserByUnlockedBadges($order = 'DESC', $limit = 7);

    /**
     * @return array
     */
    public function getAllUsernames();
}
