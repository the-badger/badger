<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Badger\GameBundle\Repository\BadgeRepositoryInterface;

/**
 * Doctrine implementation of repository for Badge entities.
 *
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
