<?php

namespace Ironforge\AchievementBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Ironforge\AchievementBundle\Repository\BadgeRepositoryInterface;

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
            ->from('AchievementBundle:Badge', 'b');

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }
}
