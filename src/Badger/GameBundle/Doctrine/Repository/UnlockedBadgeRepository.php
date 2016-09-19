<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Badger\GameBundle\Entity\BadgeInterface;
use Badger\GameBundle\Repository\TagSearchableRepositoryInterface;
use Badger\UserBundle\Entity\UserInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Badger\GameBundle\Repository\UnlockedBadgeRepositoryInterface;
use Badger\UserBundle\Entity\User;

/**
 * Doctrine implementation of repository for UnlockedBadge entities.
 *
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class UnlockedBadgeRepository extends EntityRepository implements
    UnlockedBadgeRepositoryInterface,
    TagSearchableRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUnlockedBadgeIdsByUser(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b.id')
            ->from('GameBundle:UnlockedBadge', 'ub')
            ->leftJoin('ub.badge', 'b')
            ->where($qb->expr()->eq('ub.user', '?1'))
            ->setParameter(1, $user);

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
