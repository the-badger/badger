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
    protected $repository;

    /** @var RemoverInterface */
    protected $remover;

    /** @var SaverInterface */
    protected $saver;

    /**
     * @param BadgeVoteRepositoryInterface $repository
     * @param RemoverInterface             $remover
     * @param SaverInterface               $saver
     */
    public function __construct(
        BadgeVoteRepositoryInterface $repository,
        RemoverInterface $remover,
        SaverInterface $saver
    ) {
        $this->repository = $repository;
        $this->remover    = $remover;
        $this->saver      = $saver;
    }

    /**
     * Toggle the vote of a user from its new opinion.
     *
     * 3 cases:
     * - User already voted the same opinion, we deactivated the vote.
     * - User already voted with the opposite opinion, we change the vote.
     * - User has not voted, we add a new vote.
     *
     * @param UserInterface          $user
     * @param BadgeProposalInterface $badgeProposal
     * @param bool                   $opinion
     */
    public function toggleVote(UserInterface $user, BadgeProposalInterface $badgeProposal, $opinion)
    {
        $existingVote = $this->findVote($user, $badgeProposal);

        if (null !== $existingVote) {
            if ($existingVote->getOpinion() === $opinion) {
                $this->remover->remove($existingVote);

                return;
            }

            $existingVote->setOpinion($opinion);
            $this->saver->save($existingVote);

            return;
        }

        $vote = new BadgeVote();
        $vote
            ->setUser($user)
            ->setBadgeProposal($badgeProposal)
            ->setOpinion($opinion);
        $this->saver->save($vote);
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
        return $this->repository->findOneBy([
            'user'          => $user,
            'badgeProposal' => $badgeProposal
        ]);
    }
}
