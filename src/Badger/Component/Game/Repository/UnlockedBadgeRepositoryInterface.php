<?php

namespace Badger\Component\Game\Repository;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\UserBundle\Entity\UserInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Badger\Component\Tag\Model\TagInterface;
use Badger\UserBundle\Entity\User;

/**
 * Repository interface for UnlockedBadge entities.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
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
