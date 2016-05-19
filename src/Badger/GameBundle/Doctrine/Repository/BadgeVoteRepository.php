<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Badger\GameBundle\Entity\BadgeProposalInterface;
use Badger\GameBundle\Repository\BadgeVoteRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Doctrine implementation of repository for BadgeVote entities.
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeVoteRepository extends EntityRepository implements BadgeVoteRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUpvotesCount(BadgeProposalInterface $badgeProposal)
    {
        $query = $this->createQueryBuilder('v')
            ->select("sum(v.vote) as upvotes_count")
            ->where('v.badgeProposal = :badgeProposalId')
            ->setParameter('badgeProposalId', $badgeProposal)
            ->andWhere('v.vote > 0')
            ->getQuery();

        return (int) $query->getSingleResult()['upvotes_count'];
    }

    /**
     * {@inheritdoc}
     */
    public function getDownvotesCount(BadgeProposalInterface $badgeProposal)
    {
        $query = $this->createQueryBuilder('v')
            ->select("sum(v.vote) as downvotes_count")
            ->where('v.badgeProposal = :badgeProposalId')
            ->setParameter('badgeProposalId', $badgeProposal)
            ->andWhere('v.vote < 0')
            ->getQuery();

        return - (int) $query->getSingleResult()['downvotes_count'];
    }
}
