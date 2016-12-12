<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Badger\Component\Game\Repository\QuestRepositoryInterface;
use Badger\Component\Game\Repository\TagSearchableRepositoryInterface;
use Badger\Component\Tag\Taggable\TaggableInterface;
use Badger\Component\User\Model\UserInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;

/**
 * Doctrine implementation of repository for Quest entities.
 *
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class QuestRepository extends EntityRepository implements QuestRepositoryInterface, TagSearchableRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuestsOrdered($field, $order = 'DESC')
    {
        $qb = $this->createQueryBuilder('quest');
        $qb->orderBy(sprintf('quest.%s', $field), $order);

        return $qb->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveQuests()
    {
        $today = new \DateTime('today midnight');

        $qb = $this->createQueryBuilder('quest');
        $qb->where('quest.startDate <= :today');
        $qb->andWhere('quest.endDate >= :today')->setParameter('today', $today);

        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableQuestsForUser(TaggableInterface $user)
    {
        $tagIds = [];
        foreach ($user->getTags() as $tag) {
            $tagIds[] = $tag->getId();
        }

        $today = new \DateTime('today midnight');

        $qb = $this->createQueryBuilder('quest');
        $qb->leftJoin('quest.tags', 'tags')
            ->leftJoin('quest.completions', 'qc', 'WITH', 'qc.user = :user AND qc.pending = 0')
            ->where('qc.id IS NULL')
            ->andWhere('tags.id IN (:tagIds)')
            ->andWhere('quest.startDate <= :today')
            ->andWhere('quest.endDate >= :today')
            ->setMaxResults(15)
            ->orderBy('quest.endDate')
            ->groupBy('quest.id')
            ->setParameter('user', $user)
            ->setParameter('tagIds', $tagIds, Connection::PARAM_STR_ARRAY)
            ->setParameter('today', $today)
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getCompletedQuestsForUser(UserInterface $user)
    {
        $qb = $this->createQueryBuilder('quest');
        $qb->innerJoin('quest.completions', 'qc')
            ->setMaxResults(15)
            ->orderBy('qc.completionDate')
            ->groupBy('quest.id');

        return $qb->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getPassedQuestsSince()
    {
        //TODO
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

        $qb = $this->createQueryBuilder('quest');
        $qb->leftJoin('quest.tags', 't')
            ->where('t.id IN (:ids)')->setParameter('ids', $tagIds, Connection::PARAM_STR_ARRAY)
            ->setMaxResults(15)
            ->groupBy('quest.id');

        return $qb->getQuery()->getResult();
    }
}
