<?php

namespace Ironforge\GameBundle\Doctrine\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Ironforge\GameBundle\Repository\UnlockedBadgeRepositoryInterface;
use Ironforge\UserBundle\Entity\User;

/**
 * Doctrine implementation of repository for UnlockedBadge entities.
 *
 * @author Adrien Pétremann <petremann.adrien@gmail.com>
 */
class UnlockedBadgeRepository extends EntityRepository implements UnlockedBadgeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUnlockedBadgeIdsByUser(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b.id')
            ->from('GameBundle:UnlockedBadge', 'ub')
            ->leftjoin('ub.badge', 'b')
            ->where($qb->expr()->eq('ub.user', '?1'))
            ->setParameter(1, $user);

        $queryResult = $qb->getQuery()->getScalarResult();

        return array_column($queryResult, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function findByTags(array $tags)
    {
        $tagIds = [];
        foreach ($tags as $tag) {
            $tagIds[] = $tag->getId();
        }

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ub')
            ->from('GameBundle:UnlockedBadge', 'ub')
            ->leftjoin('ub.badge', 'b')
            ->leftJoin('b.tags', 't')
            ->where('t.id IN (:ids)')->setParameter('ids', $tagIds, Connection::PARAM_STR_ARRAY)
            ->orderBy('ub.unlockedDate', 'desc')
            ->setMaxResults(15)
            ->groupBy('ub.id');

        return $qb->getQuery()->getResult(Query::HYDRATE_OBJECT);
    }
}
