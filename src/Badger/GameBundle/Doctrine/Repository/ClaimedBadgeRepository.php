<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Badger\GameBundle\Repository\ClaimedBadgeRepositoryInterface;
use Badger\UserBundle\Entity\User;

/**
 * Doctrine implementation of repository for ClaimedBadge entities.
 *
 * @author  Adrien Pétremann <adrien.petremann@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
            ->leftJoin('cb.badge', 'b')
            ->where($qb->expr()->eq('cb.user', '?1'))
            ->andWhere($qb->expr()->eq('cb.refused', ':refused'))
            ->setParameter(1, $user)
            ->setParameter('refused', false);

        $queryResult = $qb->getQuery()->getScalarResult();

        return array_column($queryResult, 'id');
    }
}
