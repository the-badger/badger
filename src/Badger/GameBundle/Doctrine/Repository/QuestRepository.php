<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Badger\GameBundle\Repository\QuestRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Doctrine implementation of repository for Quest entities.
 *
 * @author Olivier Soulet <olivier.soulet@akeneo.com>
 */
class QuestRepository extends EntityRepository implements QuestRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function countAll()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select($qb->expr()->count('b'))
            ->from('GameBundle:Quest', 'b');

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }
}
