<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Badger\Component\Game\Repository\QuestCompletionRepositoryInterface;
use Badger\Component\Game\Repository\TagSearchableRepositoryInterface;
use Badger\UserBundle\Entity\User;
use Badger\Component\User\Model\UserInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class QuestCompletionRepository extends EntityRepository implements
    QuestCompletionRepositoryInterface,
    TagSearchableRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByTags(array $tags)
    {
        $tagIds = [];
        foreach ($tags as $tag) {
            $tagIds[] = $tag->getId();
        }

        $qb = $this->createQueryBuilder('qc');
        $qb->leftJoin('qc.quest', 'q')
            ->leftJoin('q.tags', 't')
            ->where('t.id IN (:ids)')->setParameter('ids', $tagIds, Connection::PARAM_STR_ARRAY)
            ->orderBy('qc.completionDate', 'desc')
            ->setMaxResults(15)
            ->groupBy('qc.id');

        return $qb->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getQuestIdsClaimedByUser(UserInterface $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('quest.id')
            ->from('GameBundle:QuestCompletion', 'completion')
            ->leftJoin('completion.quest', 'quest')
            ->where('completion.user = :user')
            ->andWhere('completion.pending = 1')
            ->setParameter('user', $user);

        $queryResult = $qb->getQuery()->getScalarResult();

        return array_column($queryResult, 'id');
    }
}
