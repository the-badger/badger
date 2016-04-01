<?php

namespace Ironforge\GameBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Ironforge\GameBundle\Repository\BadgeRepositoryInterface;

/**
 * Doctrine implementation of repository for Badge entities.
 *
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class BadgeRepository extends EntityRepository implements BadgeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function countAll()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select($qb->expr()->count('b'))
            ->from('GameBundle:Badge', 'b');

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }
}
