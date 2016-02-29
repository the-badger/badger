<?php

namespace Ironforge\AchievementBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Ironforge\UserBundle\Entity\User;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class ClaimedBadgeRepository extends EntityRepository
{
    /**
     * Get all Badge ids claimed by the given $user.
     *
     * @param User $user
     *
     * @return array
     */
    public function getBadgeIdsClaimedByUser(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b.id')
            ->from('AchievementBundle:ClaimedBadge', 'cb')
            ->leftjoin('cb.badge', 'b')
            ->where($qb->expr()->eq('cb.user', '?1'))
            ->setParameter(1, $user);

        $queryResult = $qb->getQuery()->getScalarResult();

        return array_column($queryResult, 'id');
    }
}
