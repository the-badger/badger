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
    public function findBadgeProposalVotes()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p.id, SUM(uv.vote) AS upvotes, SUM(dv.vote) AS downvotes')
            ->leftJoin('p.badge_votes', 'uv', 'WITH', 'uv.vote > 0')
            ->leftJoin('p.badge_votes', 'dv', 'WITH', 'dv.vote < 0')
            ->groupBy('p.id')
            ->getQuery();

        return $query->getArrayResult();
    }
}
