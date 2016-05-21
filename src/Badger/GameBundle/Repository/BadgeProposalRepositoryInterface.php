<?php

namespace Badger\GameBundle\Repository;

use Badger\GameBundle\Entity\BadgeProposalInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Repository interface for BadgeProposal entities.
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface BadgeProposalRepositoryInterface extends ObjectRepository
{
    /**
     * Returns each proposal id, associated with count of upvotes and count of downvotes.
     *
     * @return ArrayCollection
     */
    public function findVoteCounts();

    /**
     * Returns each proposal, sorted by their score (upvotes - downvotes)
     *
     * @return BadgeProposalInterface[]
     */
    public function findAllSorted();
}
