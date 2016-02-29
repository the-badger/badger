<?php

namespace Ironforge\AchievementBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Ironforge\AchievementBundle\Entity\Badge;
use Ironforge\UserBundle\Entity\User;

/**
 * @author Adrien Pétremann <petremann.adrien@gmail.com>
 */
class UnlockedBadgeRepository extends EntityRepository
{
    /**
     * Get all Badge ids unlocked by the given $user.
     *
     * @param User $user
     *
     * @return array
     */
    public function getUnlockedBadgeIdsByUser(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b.id')
            ->from('AchievementBundle:UnlockedBadge', 'ub')
            ->leftjoin('ub.badge', 'b')
            ->where($qb->expr()->eq('ub.user', '?1'))
            ->setParameter(1, $user);

        $queryResult = $qb->getQuery()->getScalarResult();

        return array_column($queryResult, 'id');
    }
}
