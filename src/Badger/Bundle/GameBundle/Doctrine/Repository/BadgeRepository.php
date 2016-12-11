<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Badger\GameBundle\Repository\BadgeRepositoryInterface;

/**
 * Doctrine implementation of repository for Badge entities.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
