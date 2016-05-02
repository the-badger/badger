<?php

namespace Badger\GameBundle\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Badger\UserBundle\Entity\User;

/**
 * Repository interface for ClaimedBadge entities.
 *
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface ClaimedBadgeRepositoryInterface extends ObjectRepository
{
    /**
     * Get all Badge ids claimed by the given $user.
     *
     * @param User $user
     *
     * @return array
     */
    public function getBadgeIdsClaimedByUser(User $user);
}
