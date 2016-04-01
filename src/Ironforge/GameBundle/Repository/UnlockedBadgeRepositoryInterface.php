<?php

namespace Ironforge\GameBundle\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Ironforge\TagBundle\Entity\TagInterface;
use Ironforge\UserBundle\Entity\User;

/**
 * Repository interface for UnlockedBadge entities.
 *
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
interface UnlockedBadgeRepositoryInterface extends ObjectRepository
{
    /**
     * Get all Badge ids unlocked by the given $user.
     *
     * @param User $user
     *
     * @return array
     */
    public function getUnlockedBadgeIdsByUser(User $user);


    /**
     * Return all ClaimedBadge filtered by Badge's Tag
     *
     * @param TagInterface[] $tags
     *
     * @return mixed
     */
    public function findByTags(array $tags);
}
