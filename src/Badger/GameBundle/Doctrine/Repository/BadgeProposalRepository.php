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
    public function findVoteCounts()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p.id, SUM(uv.opinion) AS upvotes, - SUM(dv.opinion) AS downvotes')
            ->leftJoin('p.badgeVotes', 'uv', 'WITH', 'uv.opinion > 0')
            ->leftJoin('p.badgeVotes', 'dv', 'WITH', 'dv.opinion < 0')
            ->groupBy('p.id')
            ->getQuery();

        return $query->getArrayResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findAllSorted()
    {
        $query = $this->createQueryBuilder('p')
            ->addSelect('SUM(v.opinion) AS HIDDEN opinion_sum')
            ->leftJoin('p.badgeVotes', 'v')
            ->groupBy('p.id')
            ->orderBy('opinion_sum', 'DESC')
            ->getQuery();

        return $query->getResult();
    }
}
