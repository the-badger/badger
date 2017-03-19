<?php

namespace Badger\Component\Game\Repository;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\Game\Model\TagInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @param UserInterface $user
     *
     * @return array
     */
    public function getUnlockedBadgeIdsByUser(UserInterface $user);

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
