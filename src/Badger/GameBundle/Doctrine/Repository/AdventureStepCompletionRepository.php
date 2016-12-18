<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Badger\GameBundle\Entity\AdventureInterface;
use Badger\GameBundle\Repository\AdventureStepCompletionRepositoryInterface;
use Badger\UserBundle\Entity\UserInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class AdventureStepCompletionRepository extends EntityRepository implements AdventureStepCompletionRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function userAdventureCompletedSteps(UserInterface $user, AdventureInterface $adventure)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from('GameBundle:AdventureStep', 's')
            ->leftJoin('s.completions', 'sc')
            ->where('sc.user = :user')->setParameter(':user', $user)
            ->andWhere('s.adventure = :adventure')->setParameter(':adventure', $adventure)
            ->andWhere('sc.pending = 0');

        $queryResult = $qb->getQuery()->getResult();

        return $queryResult;
    }

    /**
     * {@inheritdoc}
     */
    public function userAdventureClaimedSteps(UserInterface $user, AdventureInterface $adventure)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from('GameBundle:AdventureStep', 's')
            ->leftJoin('s.completions', 'sc')
            ->where('sc.user = :user')->setParameter(':user', $user)
            ->andWhere('s.adventure = :adventure')->setParameter(':adventure', $adventure)
            ->andWhere('sc.pending = 1');

        $queryResult = $qb->getQuery()->getResult();

        return $queryResult;
    }

    /**
     * {@inheritdoc}
     */
    public function userCompletedSteps(UserInterface $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a as adventure, COUNT(sc) as completions')
            ->from('GameBundle:Adventure', 'a')
            ->leftJoin('a.steps', 's')
            ->leftJoin('s.completions', 'sc')
            ->where('sc.user = :user')->setParameter(':user', $user)
            ->andWhere('sc.pending = 0')
            ->groupBy('s.adventure');

        $queryResult = $qb->getQuery()->getResult();

        return $queryResult;
    }
}
