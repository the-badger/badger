<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Doctrine\Repository\BadgeVoteRepository;
use Badger\GameBundle\Helper\BadgeVoteSummary;
use Badger\GameBundle\Repository\BadgeProposalRepositoryInterface;
use FOS\UserBundle\Model\UserInterface;

/**
 * Factory for BadgeVoteSummary creation
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeVoteSummaryFactory
{
    /** @var BadgeProposalRepositoryInterface */
    protected $badgeProposalRepository;

    /** @var BadgeVoteRepository */
    protected $badgeVoteRepository;

    /**
     * @param BadgeProposalRepositoryInterface $badgeProposalRepository
     * @param BadgeVoteRepository              $badgeVoteRepository
     */
    public function __construct(
        BadgeProposalRepositoryInterface $badgeProposalRepository,
        BadgeVoteRepository $badgeVoteRepository
    ) {
        $this->badgeProposalRepository = $badgeProposalRepository;
        $this->badgeVoteRepository     = $badgeVoteRepository;
    }

    /**
     * @param UserInterface $user
     *
     * @return BadgeVoteSummary
     */
    public function create(UserInterface $user)
    {
        $badgeVoteSummary = new BadgeVoteSummary();
        $badgeVoteSummary
            ->setBadgeProposals($this->badgeProposalRepository->findAllSorted())
            ->setUserVotes($this->badgeVoteRepository->findBy(['user' => $user]))
            ->setVoteCounts($this->badgeProposalRepository->findVoteCounts());

        return $badgeVoteSummary;
    }
}
