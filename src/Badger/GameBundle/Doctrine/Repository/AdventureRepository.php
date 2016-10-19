<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Badger\GameBundle\Repository\AdventureRepositoryInterface;
use Badger\TagBundle\Taggable\TaggableInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;

/**
 * Doctrine implementation of repository for Adventure entities.
 *
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class AdventureRepository extends EntityRepository implements AdventureRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAvailableAdventuresForUser(TaggableInterface $user)
    {
        $tagIds = [];
        foreach ($user->getTags() as $tag) {
            $tagIds[] = $tag->getId();
        }

        $qb = $this->createQueryBuilder('adventure');
        $qb->leftJoin('adventure.tags', 'tags')
            ->leftJoin('adventure.steps', 's')
            ->leftJoin('s.completions', 'sc', 'WITH', 'sc.user = :user AND sc.pending = 0')
            ->setParameter('user', $user)
            ->having('COUNT(sc) < COUNT(s)')
            ->andWhere('tags.id IN (:tagIds)')
            ->setMaxResults(15)
            ->groupBy('adventure.id')
            ->setParameter('tagIds', $tagIds, Connection::PARAM_STR_ARRAY)
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getCompletedAdventuresForUser(TaggableInterface $user)
    {
        $tagIds = [];
        foreach ($user->getTags() as $tag) {
            $tagIds[] = $tag->getId();
        }

        $qb = $this->createQueryBuilder('adventure');
        $qb->leftJoin('adventure.tags', 'tags')
            ->leftJoin('adventure.steps', 's')
            ->leftJoin('s.completions', 'sc', 'WITH', 'sc.user = :user AND sc.pending = 0')
            ->setParameter('user', $user)
            ->having('COUNT(sc) = COUNT(s)')
            ->andWhere('tags.id IN (:tagIds)')
            ->setMaxResults(15)
            ->groupBy('adventure.id')
            ->setParameter('tagIds', $tagIds, Connection::PARAM_STR_ARRAY)
        ;

        return $qb->getQuery()->getResult();
    }
}
