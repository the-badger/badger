<?php

namespace Badger\GameBundle\Repository;

use Badger\GameBundle\Entity\BadgeProposalInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Repository interface for BadgeVote entities.
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface BadgeVoteRepositoryInterface extends ObjectRepository
{
    /**
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return integer
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUpvotesCount(BadgeProposalInterface $badgeProposal);

    /**
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return integer
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getDownvotesCount(BadgeProposalInterface $badgeProposal);
}
