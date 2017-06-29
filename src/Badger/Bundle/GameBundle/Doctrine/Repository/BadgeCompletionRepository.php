<?php

namespace Badger\Bundle\GameBundle\Doctrine\Repository;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\Game\Model\TagInterface;
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

    /**
     * {@inheritdoc}
     */
    public function getMostUnlockedBadgesForMonth($month, $year, TagInterface $tag, $limit = 3)
    {
        $lastDay = date('t', mktime(0, 0, 0, $month, 1, $year));

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('COUNT(DISTINCT(bc.id)) as nbCompletions, b as badge')
            ->from('GameBundle:Badge', 'b')
            ->leftJoin('b.completions', 'bc')
            ->leftJoin('b.tags', 't')
            ->where('t.id = :tagId')
                ->setParameter('tagId', $tag->getId())
            ->andWhere('bc.pending = 0')
            ->andWhere('bc.completionDate >= :firstDayOfMonth')
                ->setParameter('firstDayOfMonth', date(sprintf('%s-%s-01', $year, $month)))
            ->andWhere('bc.completionDate <= :lastDayOfMonth')
                ->setParameter('lastDayOfMonth', date(sprintf('%s-%s-%s', $year, $month, $lastDay)))
            ->groupBy('b.id')
            ->orderBy('nbCompletions', 'desc')
            ->setMaxResults($limit)
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getTopNumberOfUnlocksForMonth($month, $year, TagInterface $tag, $user = null)
    {
        $lastDay = date('t', mktime(0, 0, 0, $month, 1, $year));

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('DISTINCT(COUNT(bc)) as nbCompletions')
            ->from('GameBundle:BadgeCompletion', 'bc')
            ->leftJoin('bc.badge', 'b')
            ->leftJoin('b.tags', 't')
            ->where('t.id = :tagId')
                ->setParameter('tagId', $tag->getId())
            ->andWhere('bc.pending = 0')
            ->andWhere('bc.completionDate >= :firstDayOfMonth')
                ->setParameter('firstDayOfMonth', date(sprintf('%s-%s-01', $year, $month)))
            ->andWhere('bc.completionDate <= :lastDayOfMonth')
                ->setParameter('lastDayOfMonth', date(sprintf('%s-%s-%s', $year, $month, $lastDay)))
            ->groupBy('bc.user')
            ->orderBy('nbCompletions', 'desc')
            ->setMaxResults(3)
        ;

        if (null !== $user) {
            $qb->andWhere('bc.user = :user')
                ->setParameter('user', $user);
        }

        return $qb->getQuery()->getResult();
    }
}
