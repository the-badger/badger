<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Badger\GameBundle\Repository\BadgeProposalRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Doctrine implementation of repository for BadgeProposal entities.
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeProposalRepository extends EntityRepository implements BadgeProposalRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findAllSorted()
    {
        /**
         * The eager loading of BadgeVotes need to do a left join to proposal. But this is not possible with this
         * kind of query because we need to group by proposal id to get order, and doctrines does not allow left join
         * to sub queries (or it need to write full SQL query).
         * So, we execute 2 queries:
         * - first one get the proposal ids in the needed order
         * - second one is a standard findAll, where left join to proposals is automatically done by EAGER.
         * Then, we just map the 2 queries to have proposals in the right order.
         */
        $queryOrder = $this->createQueryBuilder('p')
            ->select('p.id')
            ->addSelect('COALESCE(SUM(v.opinion),0) AS HIDDEN opinion_sum')
            ->leftJoin('p.badgeVotes', 'v')
            ->groupBy('p.id')
            ->orderBy('opinion_sum', 'DESC')
            ->getQuery();
        $orderProposalIds = $queryOrder->getArrayResult();

        $proposals = $this->findAll();
        $result = [];
        foreach ($orderProposalIds as $orderProposalId) {
            foreach ($proposals as $proposal) {
                if ($proposal->getId() === $orderProposalId['id']) {
                    // Should be optimized by removing the matched proposals
                    array_push($result, $proposal);
                }
            }
        }

        return $result;
    }
}
