<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Badger\GameBundle\Repository\QuestRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Doctrine implementation of repository for Quest entities.
 *
 * @author    Olivier Soulet <olivier.soulet@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
