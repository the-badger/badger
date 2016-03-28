<?php

namespace Ironforge\UserBundle\Repository;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
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
}
