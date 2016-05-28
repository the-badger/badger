<?php

namespace spec\Badger\GameBundle\Vote;

use Badger\GameBundle\Entity\BadgeProposalInterface;
use Badger\GameBundle\Entity\BadgeVoteInterface;
use Badger\GameBundle\Repository\BadgeVoteRepositoryInterface;
use Badger\StorageUtilsBundle\Remover\RemoverInterface;
use Badger\StorageUtilsBundle\Saver\SaverInterface;
use Badger\UserBundle\Entity\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BadgeVoteEngineSpec extends ObjectBehavior
{
    function let(
        BadgeVoteRepositoryInterface $repository,
        SaverInterface $saver
    ) {
        $this->beConstructedWith($repository, $saver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Badger\GameBundle\Vote\BadgeVoteEngine');
    }

    function it_should_create_a_vote(
        $repository,
        $saver,
        UserInterface $user,
        BadgeProposalInterface $badgeProposal
    )
    {
        $repository->findOneBy([
            'user'          => $user,
            'badgeProposal' => $badgeProposal,
        ])->willReturn(null);

        $saver->save(Argument::any())->shouldBeCalled();
        $this->toggleVote($user, $badgeProposal, true);
    }

    function it_should_toggle_the_opinion(
        $repository,
        $saver,
        BadgeVoteInterface $badgeVote,
        UserInterface $user,
        BadgeProposalInterface $badgeProposal
    ) {
        $repository->findOneBy([
            'user'          => $user,
            'badgeProposal' => $badgeProposal,
        ])->willReturn($badgeVote);

        $badgeVote->getOpinion()->willReturn(false);
        $badgeVote->setOpinion(true)->shouldBeCalled();
        $saver->save($badgeVote)->shouldBeCalled();
        $this->toggleVote($user, $badgeProposal, true);
    }

    function it_should_deactivate_the_opinion(
        $repository,
        $saver,
        BadgeVoteInterface $badgeVote,
        UserInterface $user,
        BadgeProposalInterface $badgeProposal
    ) {
        $repository->findOneBy([
            'user'          => $user,
            'badgeProposal' => $badgeProposal,
        ])->willReturn($badgeVote);

        $badgeVote->getOpinion()->willReturn(true);
        $badgeVote->setOpinion(null)->shouldBeCalled();
        $saver->save($badgeVote)->shouldBeCalled();
        $this->toggleVote($user, $badgeProposal, true);
    }
}
