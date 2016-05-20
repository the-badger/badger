<?php

namespace Badger\GameBundle\Helper;

use Badger\GameBundle\Entity\BadgeProposalInterface;
use Badger\GameBundle\Entity\BadgeVoteInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Summary of the badge votes to present data
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeVoteSummary
{
    /** @var BadgeProposalInterface[] */
    protected $badgeProposals;

    /** @var BadgeVoteInterface[] */
    protected $userVotes;

    /** @var ArrayCollection */
    protected $badgeProposalVotes;

    /**
     * @param BadgeProposalInterface[] $badgeProposals
     */
    public function setBadgeProposals(array $badgeProposals)
    {
        $this->badgeProposals = $badgeProposals;
    }

    /**
     * @param BadgeVoteInterface[] $badgeVotes
     */
    public function setUserVotes($badgeVotes)
    {
        $this->userVotes = $badgeVotes;
    }

    /**
     * @param ArrayCollection $badgeProposalVotes
     */
    public function setBadgeProposalVotes($badgeProposalVotes)
    {
        $this->badgeProposalVotes = $badgeProposalVotes;
    }

    /**
     * @return BadgeProposalInterface[]
     */
    public function getBadgeProposals()
    {
        return $this->badgeProposals;
    }

    /**
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return bool
     */
    public function hasUpvoted(BadgeProposalInterface $badgeProposal)
    {
        foreach ($this->userVotes as $userVote) {
            if ($userVote->getBadgeProposal() === $badgeProposal) {
                return true === $userVote->getVote();
            }
        }

        return false;
    }

    /**
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return bool
     */
    public function hasDownvoted(BadgeProposalInterface $badgeProposal)
    {
        foreach ($this->userVotes as $userVote) {
            if ($userVote->getBadgeProposal() === $badgeProposal) {
                return false === $userVote->getVote();
            }
        }

        return false;
    }

    /**
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return int
     */
    public function countUpvotes(BadgeProposalInterface $badgeProposal)
    {
        foreach ($this->badgeProposalVotes as $badgeProposalVote) {
            if ($badgeProposalVote['id'] === $badgeProposal->getId()) {
                return (int) $badgeProposalVote['upvotes'];
            }
        }

        return 0;
    }

    /**
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return int
     */
    public function countDownvotes(BadgeProposalInterface $badgeProposal)
    {
        foreach ($this->badgeProposalVotes as $badgeProposalVote) {
            if ($badgeProposalVote['id'] === $badgeProposal->getId()) {
                return - (int) $badgeProposalVote['downvotes'];
            }
        }

        return 0;
    }

    /**
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return int
     */
    public function score(BadgeProposalInterface $badgeProposal)
    {
        return $this->countUpvotes($badgeProposal) - $this->countDownvotes($badgeProposal);
    }
}
