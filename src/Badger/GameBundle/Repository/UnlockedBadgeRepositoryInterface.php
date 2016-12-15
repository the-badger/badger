<?php

namespace Badger\GameBundle\Repository;

use Badger\GameBundle\Entity\BadgeInterface;
use Badger\UserBundle\Entity\UserInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Badger\TagBundle\Entity\TagInterface;
use Badger\UserBundle\Entity\User;

/**
 * Repository interface for UnlockedBadge entities.
 *
 * @author  Adrien Pétremann <adrien.petremann@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
     * Return whether the given $user has the given $badge.
     *
     * @param UserInterface  $user
     * @param BadgeInterface $badge
     *
     * @return bool
     */
    public function userHasBadge(UserInterface $user, BadgeInterface $badge);


    /**
     * Return all UnlockedBadge filtered by Badge's Tag
     *
     * @param TagInterface[] $tags
     *
     * @return mixed
     */
    public function findByTags(array $tags);
}
