<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Badger\GameBundle\Repository\ClaimedBadgeRepositoryInterface;
use Badger\UserBundle\Entity\User;

/**
 * Doctrine implementation of repository for ClaimedBadge entities.
 *
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
