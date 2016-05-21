<?php

namespace Badger\GameBundle\Twig;
use Badger\GameBundle\Entity\BadgeProposal;
use Badger\GameBundle\Entity\BadgeVoteInterface;
use Badger\UserBundle\Entity\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class VoteExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('has_upvoted', [$this, 'hasUpvoted']),
            new \Twig_SimpleFunction('has_downvoted', [$this, 'hasDownvoted']),
        );
    }

    /**
     * @param BadgeVoteInterface[] $badgeVotes
     * @param BadgeProposal        $badgeProposal
     *
     * @return bool
     */
    public function hasUpvoted(array $badgeVotes, BadgeProposal $badgeProposal)
    {
        foreach ($badgeVotes as $badgeVote) {
            if ($badgeVote->getBadgeProposal() === $badgeProposal) {
                return $badgeVote->getOpinion();
            }
        }

        return false;
    }

    /**
     * @param BadgeVoteInterface[] $badgeVotes
     * @param BadgeProposal        $badgeProposal
     *
     * @return bool
     */
    public function hasDownvoted(array $badgeVotes, BadgeProposal $badgeProposal)
    {
        foreach ($badgeVotes as $badgeVote) {
            if ($badgeVote->getBadgeProposal() === $badgeProposal) {
                return !$badgeVote->getOpinion();
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'vote';
    }
}
