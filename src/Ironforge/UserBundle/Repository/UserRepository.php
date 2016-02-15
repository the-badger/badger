<?php

namespace Ironforge\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class UserRepository extends EntityRepository
{
    /**
     * @return int
     */
    public function countAll()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select($qb->expr()->count('u'))
            ->from('UserBundle:User', 'u');

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    /**
     * @param string $order
     * @param int    $limit
     *
     * @return int
     */
    public function getSortedUserByUnlockedBadges($order = 'DESC', $limit = 7)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('u AS user, COUNT(ub.id) AS nbUnlockedBadges')
            ->from('UserBundle:User', 'u')
            ->leftJoin('AchievementBundle:UnlockedBadge', 'ub')
            ->where('ub.user = u')
            ->setMaxResults($limit)
            ->orderBy('nbUnlockedBadges', $order)
            ->groupBy('u')
        ;

        $query = $qb->getQuery();

        return $query->getResult();
    }
}
