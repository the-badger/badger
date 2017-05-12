<?php

namespace Badger\Bundle\GameBundle\Doctrine\Repository;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\Game\Repository\BadgeCompletionRepositoryInterface;
use Badger\Component\Game\Repository\TagSearchableRepositoryInterface;
use Badger\Component\User\Model\UserInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class BadgeCompletionRepository extends EntityRepository implements
    BadgeCompletionRepositoryInterface,
    TagSearchableRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCompletionBadgesByUser(UserInterface $user, $pending = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('badge.id')
            ->from('GameBundle:BadgeCompletion', 'completion')
            ->leftJoin('completion.badge', 'badge')
            ->where('completion.user = :user')
            ->setParameter('user', $user);

        if (is_bool($pending)) {
            $qb->andWhere('completion.pending = :pending')
                ->setParameter('pending', $pending ? '1' : '0');
        }

        $queryResult = $qb->getQuery()->getScalarResult();

        return array_column($queryResult, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function userHasBadge(UserInterface $user, BadgeInterface $badge)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('COUNT(badge.id)')
            ->from('GameBundle:BadgeCompletion', 'completion')
            ->leftJoin('completion.badge', 'badge')
            ->where('completion.user = :user')
            ->andWhere('completion.badge = :badge')
            ->andWhere('completion.pending = 0')
            ->setParameter('user', $user)
            ->setParameter('badge', $badge);

        return (1 === intval($qb->getQuery()->getSingleScalarResult()));
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

        $qb = $this->createQueryBuilder('bc');
        $qb->leftJoin('bc.badge', 'b')
            ->leftJoin('b.tags', 't')
            ->where('t.id IN (:ids)')->setParameter('ids', $tagIds, Connection::PARAM_STR_ARRAY)
            ->orderBy('bc.completionDate', 'desc')
            ->setMaxResults(15)
            ->groupBy('bc.id');

        return $qb->getQuery()->getResult();
    }


}
