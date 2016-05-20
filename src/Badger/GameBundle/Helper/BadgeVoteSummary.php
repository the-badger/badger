<?php

namespace Badger\GameBundle\Helper;

use Badger\GameBundle\Entity\BadgeProposalInterface;
use Badger\GameBundle\Entity\BadgeVoteInterface;

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
}
