<?php

namespace Badger\GameBundle\Helper;

use Badger\GameBundle\Entity\BadgeProposalInterface;
use Badger\GameBundle\Entity\BadgeVote;
use Badger\GameBundle\Entity\BadgeVoteInterface;
use Badger\GameBundle\Repository\BadgeVoteRepositoryInterface;
use Badger\StorageUtilsBundle\Remover\RemoverInterface;
use Badger\StorageUtilsBundle\Saver\SaverInterface;
use Badger\UserBundle\Entity\UserInterface;

/**
 * Engine to create, update and destroy badge votes for users and proposals
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeVoteEngine
{
    /** @var BadgeVoteRepositoryInterface */
    var $badgeVoteRepository;

    /** @var RemoverInterface */
    var $badgeVoteRemover;

    /** @var SaverInterface */
    var $badgeVoteSaver;

    public function __construct(
        BadgeVoteRepositoryInterface $badgeVoteRepository,
        RemoverInterface $badgeVoteRemover,
        SaverInterface $badgeVoteSaver
    ) {
        $this->badgeVoteRepository = $badgeVoteRepository;
        $this->badgeVoteRemover    = $badgeVoteRemover;
        $this->badgeVoteSaver      = $badgeVoteSaver;
    }

    /**
     * @param UserInterface          $user
     * @param BadgeProposalInterface $badgeProposal
     */
    public function toggleUpvote(UserInterface $user, BadgeProposalInterface $badgeProposal)
    {
        $this->toggleVote($user, $badgeProposal, true);
    }

    /**
     * @param UserInterface          $user
     * @param BadgeProposalInterface $badgeProposal
     */
    public function toggleDownvote(UserInterface $user, BadgeProposalInterface $badgeProposal)
    {
        $this->toggleVote($user, $badgeProposal, false);
    }

    /**
     * @param UserInterface          $user
     * @param BadgeProposalInterface $badgeProposal
     */
    public function removeVote(UserInterface $user, BadgeProposalInterface $badgeProposal)
    {
        $vote = $this->findVote($user, $badgeProposal);

        if (null !== $vote) {
            $this->badgeVoteRemover->remove($vote);
        }
    }

    /**
     * Change the vote of a user
     *
     * 3 cases:
     * - User already voted the same opinion, we deactivated the vote.
     * - User already voted with the opposite opinion, we change the vote.
     * - User has not voted, we add a new vote.
     *
     * @param UserInterface          $user
     * @param BadgeProposalInterface $badgeProposal
     * @param bool                   $upOrDown
     */
    protected function toggleVote(UserInterface $user, BadgeProposalInterface $badgeProposal, $upOrDown)
    {
        $existingVote = $this->findVote($user, $badgeProposal);

        if (null !== $existingVote) {
            if ($existingVote->getVote() === $upOrDown) {
                $this->badgeVoteRemover->remove($existingVote);
            } else {
                $existingVote->setVote($upOrDown);
                $this->badgeVoteSaver->save($existingVote);
            }
        } else {
            $vote = new BadgeVote();
            $vote
                ->setUser($user)
                ->setBadgeProposal($badgeProposal)
                ->setVote($upOrDown);
            $this->badgeVoteSaver->save($vote);
        }
    }

    /**
     * Return a vote if existing
     *
     * @param UserInterface $user
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return BadgeVoteInterface|null
     */
    protected function findVote(UserInterface $user, BadgeProposalInterface $badgeProposal)
    {
        return $this->badgeVoteRepository->findOneBy([
            'user'          => $user,
            'badgeProposal' => $badgeProposal
        ]);
    }
}
