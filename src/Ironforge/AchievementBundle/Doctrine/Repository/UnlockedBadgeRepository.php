<?php

namespace Ironforge\AchievementBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Ironforge\AchievementBundle\Entity\Badge;
use Ironforge\AchievementBundle\Repository\UnlockedBadgeRepositoryInterface;
use Ironforge\UserBundle\Entity\User;

/**
 * Doctrine implementation of repository for UnlockedBadge entities.
 *
 * @author Adrien Pétremann <petremann.adrien@gmail.com>
 */
class UnlockedBadgeRepository extends EntityRepository implements UnlockedBadgeRepositoryInterface
{
    /**
     * {@inheritdoc}
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
