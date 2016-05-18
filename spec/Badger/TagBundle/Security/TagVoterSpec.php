<?php

namespace spec\Badger\TagBundle\Security;

use Badger\GameBundle\Entity\BadgeInterface;
use Badger\TagBundle\Entity\TagInterface;
use Badger\TagBundle\Security\TagVoter;
use Badger\UserBundle\Entity\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class TagVoterSpec extends ObjectBehavior
{
    function it_is_a_voter()
    {
        $this->shouldImplement('Symfony\Component\Security\Core\Authorization\Voter\VoterInterface');
    }

    function it_grants_tag_view_on_authorized_users(
        TokenInterface $token,
        UserInterface $user,
        ArrayCollection $userTags,
        TagInterface $tagCommunity,
        TagInterface $tagPrivate
    ) {
        $userTags->add($tagCommunity);
        $userTags->add($tagPrivate);
        $userTags->toArray()->willReturn([$tagCommunity, $tagPrivate]);

        $token->getUser()->willReturn($user);
        $user->getTags()->willReturn($userTags);

        $this->vote($token, $tagCommunity, [TagVoter::VIEW])->shouldReturn(VoterInterface::ACCESS_GRANTED);
    }

    function it_does_not_grant_tag_view_on_unauthorized_users(
        TokenInterface $token,
        UserInterface $user,
        ArrayCollection $userTags,
        TagInterface $tagCommunity,
        TagInterface $tagPrivate
    ) {
        $userTags->add($tagCommunity);
        $userTags->toArray()->willReturn([$tagCommunity]);

        $token->getUser()->willReturn($user);
        $user->getTags()->willReturn($userTags);

        $this->vote($token, $tagPrivate, [TagVoter::VIEW])->shouldReturn(VoterInterface::ACCESS_DENIED);
    }

    function it_does_not_grant_tag_view_if_user_is_not_taggable(
        TokenInterface $token,
        UserInterface $user,
        TagInterface $tagPrivate
    ) {
        $token->getUser()->willReturn($user);

        $this->vote($token, $tagPrivate, [TagVoter::VIEW])->shouldReturn(VoterInterface::ACCESS_DENIED);
    }

    function it_supports_only_tag_entity(
        TokenInterface $token,
        BadgeInterface $badge
    ) {
        $this->vote($token, $badge, [TagVoter::VIEW])->shouldReturn(VoterInterface::ACCESS_ABSTAIN);
    }

    function it_supports_only_view_attribute(
        TokenInterface $token,
        TagInterface $tagCommunity
    ) {
        $this->vote($token, $tagCommunity, ['other'])->shouldReturn(VoterInterface::ACCESS_ABSTAIN);
    }
}
