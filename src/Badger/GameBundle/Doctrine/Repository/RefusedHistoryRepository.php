<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Badger\GameBundle\Repository\RefusedHistoryRepositoryInterface;
use Badger\UserBundle\Entity\UserInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Doctrine implementation of repository for Adventure entities.
 *
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class RefusedHistoryRepository extends EntityRepository implements RefusedHistoryRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRefusedEntitiesByUser(UserInterface $user, $entityType, $entityId)
    {
        $qb = $this->createQueryBuilder('refusedHistory');
        $qb->leftJoin('refusedHistory.user', 'user')
            ->where('user.username = :user')
            ->setParameter('user', $user->getUsername())
            ->andWhere('refusedHistory.entityType = :entityType')
            ->setParameter('entityType', $entityType)
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getNumberOfRefusedEntitiesByUser(UserInterface $user, $entityType, $entityId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select($qb->expr()->count('refusedHistory'));
        $qb->leftJoin('refusedHistory.user', 'user')
            ->where('user.username = :user')
            ->setParameter('user', $user->getUsername())
            ->andWhere('refusedHistory.entityType = :entityType')
            ->setParameter('entityType', $entityType)
        ;

        return $qb->getQuery()->getResult();
    }
}
