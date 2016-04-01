<?php

namespace Ironforge\GameBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Ironforge\GameBundle\Repository\ClaimedBadgeRepositoryInterface;
use Ironforge\UserBundle\Entity\User;

/**
 * Doctrine implementation of repository for ClaimedBadge entities.
 *
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class ClaimedBadgeRepository extends EntityRepository implements ClaimedBadgeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBadgeIdsClaimedByUser(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b.id')
            ->from('GameBundle:ClaimedBadge', 'cb')
            ->leftjoin('cb.badge', 'b')
            ->where($qb->expr()->eq('cb.user', '?1'))
            ->setParameter(1, $user);

        $queryResult = $qb->getQuery()->getScalarResult();

        return array_column($queryResult, 'id');
    }
}
