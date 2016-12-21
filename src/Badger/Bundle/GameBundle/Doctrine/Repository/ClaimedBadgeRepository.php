<?php

namespace Badger\Bundle\GameBundle\Doctrine\Repository;

use Badger\Component\Game\Repository\ClaimedBadgeRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Doctrine implementation of repository for ClaimedBadge entities.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class ClaimedBadgeRepository extends EntityRepository implements ClaimedBadgeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBadgeIdsClaimedByUser(UserInterface $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b.id')
            ->from('GameBundle:ClaimedBadge', 'cb')
            ->leftJoin('cb.badge', 'b')
            ->where($qb->expr()->eq('cb.user', '?1'))
            ->setParameter(1, $user);

        $queryResult = $qb->getQuery()->getScalarResult();

        return array_column($queryResult, 'id');
    }
}
