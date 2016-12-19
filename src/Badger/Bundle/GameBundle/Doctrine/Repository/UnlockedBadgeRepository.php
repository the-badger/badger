<?php

namespace Badger\Bundle\GameBundle\Doctrine\Repository;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\Game\Repository\TagSearchableRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Badger\Component\Game\Repository\UnlockedBadgeRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Doctrine implementation of repository for UnlockedBadge entities.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class UnlockedBadgeRepository extends EntityRepository implements
    UnlockedBadgeRepositoryInterface,
    TagSearchableRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUnlockedBadgeIdsByUser(UserInterface $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b.id')
            ->from('GameBundle:UnlockedBadge', 'ub')
            ->leftJoin('ub.badge', 'b')
            ->where('ub.user = :user')->setParameter(':user', $user);

        $queryResult = $qb->getQuery()->getScalarResult();

        return array_column($queryResult, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function userHasBadge(UserInterface $user, BadgeInterface $badge)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('COUNT(ub.id)')
            ->from('GameBundle:UnlockedBadge', 'ub')
            ->where('ub.user = :user')->setParameter(':user', $user)
            ->andWhere('ub.badge = :badge')->setParameter(':badge', $badge);

        return $qb->getQuery()->getSingleScalarResult() > 0;
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
            ->leftJoin('ub.badge', 'b')
            ->leftJoin('b.tags', 't')
            ->where('t.id IN (:ids)')->setParameter('ids', $tagIds, Connection::PARAM_STR_ARRAY)
            ->orderBy('ub.unlockedDate', 'desc')
            ->setMaxResults(15)
            ->groupBy('ub.id');

        return $qb->getQuery()->getResult(Query::HYDRATE_OBJECT);
    }
}
