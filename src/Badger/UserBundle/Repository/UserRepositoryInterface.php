<?php

namespace Badger\UserBundle\Repository;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
