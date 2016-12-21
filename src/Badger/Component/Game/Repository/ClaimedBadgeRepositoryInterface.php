<?php

namespace Badger\Component\Game\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Repository interface for ClaimedBadge entities.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface ClaimedBadgeRepositoryInterface extends ObjectRepository
{
    /**
     * Get all Badge ids claimed by the given $user.
     *
     * @param UserInterface $user
     *
     * @return array
     */
    public function getBadgeIdsClaimedByUser(UserInterface $user);
}
