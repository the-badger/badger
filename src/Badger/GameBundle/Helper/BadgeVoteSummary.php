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
    protected $voteCounts;

    /**
     * @param BadgeProposalInterface[] $badgeProposals
     *
     * @return BadgeVoteSummary
     */
    public function setBadgeProposals(array $badgeProposals)
    {
        $this->badgeProposals = $badgeProposals;

        return $this;
    }

    /**
     * @param BadgeVoteInterface[] $userVotes
     *
     * @return BadgeVoteSummary
     */
    public function setUserVotes($userVotes)
    {
        $this->userVotes = [];
        foreach($userVotes as $userVote) {
            $this->userVotes[$userVote->getBadgeProposal()->getId()] = $userVote->getOpinion();
        };

        return $this;
    }

    /**
     * @param ArrayCollection $voteCounts
     *
     * @return BadgeVoteSummary
     */
    public function setVoteCounts($voteCounts)
    {
        $this->voteCounts = [];
        foreach ($voteCounts as $proposalCounts) {
            $this->voteCounts[$proposalCounts['id']] = $proposalCounts;
        }

        return $this;
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
        if (isset($this->userVotes[$badgeProposal->getId()])) {
            return true === $this->userVotes[$badgeProposal->getId()];
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
        if (isset($this->userVotes[$badgeProposal->getId()])) {
            return false === $this->userVotes[$badgeProposal->getId()];
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
        if (isset($this->voteCounts[$badgeProposal->getId()])) {
            return (int) $this->voteCounts[$badgeProposal->getId()]['upvotes'];
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
        if (isset($this->voteCounts[$badgeProposal->getId()])) {
            return (int) $this->voteCounts[$badgeProposal->getId()]['downvotes'];
        }

        return 0;
    }
}
