<?php

namespace spec\Badger\TagBundle\Security;

use Badger\Component\Tag\Model\TagInterface;
use Badger\TagBundle\Security\TaggedEntityVoter;
use Badger\Component\Tag\Taggable\TaggableInterface;
use Badger\UserBundle\Entity\User;
use Badger\UserBundle\Entity\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class TaggedEntityVoterSpec extends ObjectBehavior
{
    function it_is_a_voter()
    {
        $this->shouldImplement('Symfony\Component\Security\Core\Authorization\Voter\VoterInterface');
    }

    function it_grants_entity_view_on_authorized_users(
        TokenInterface $token,
        User $user,
        ArrayCollection $userTags,
        ArrayCollection $userTagsId,
        ArrayCollection $entityTags,
        ArrayCollection $entityTagsId,
        TagInterface $tagCommunity,
        TagInterface $tagPrivate,
        TaggableInterface $taggable
    ) {
        $tagCommunity->getId()->willReturn(3);
        $tagPrivate->getId()->willReturn(4);

        $userTags->add($tagCommunity);
        $userTags->add($tagPrivate);
        $userTags->map(Argument::any())->willReturn($userTagsId);
        $userTagsId->toArray()->willReturn([3, 4]);

        $token->getUser()->willReturn($user);
        $user->getTags()->willReturn($userTags);

        $entityTags->add($tagCommunity);
        $entityTags->map(Argument::any())->willReturn($entityTagsId);
        $entityTagsId->toArray()->willReturn([3]);
        $taggable->getTags()->willReturn($entityTags);

        $this->vote($token, $taggable, [TaggedEntityVoter::VIEW])->shouldReturn(VoterInterface::ACCESS_GRANTED);
    }

    function it_does_not_grant_tag_view_on_unauthorized_users(
        TokenInterface $token,
        User $user,
        ArrayCollection $userTags,
        ArrayCollection $userTagsId,
        ArrayCollection $entityTags,
        ArrayCollection $entityTagsId,
        TagInterface $tagCommunity,
        TagInterface $tagPrivate,
        TaggableInterface $taggable
    ) {
        $tagCommunity->getId()->willReturn(3);
        $tagPrivate->getId()->willReturn(4);

        $userTags->add($tagCommunity);
        $userTags->map(Argument::any())->willReturn($userTagsId);
        $userTagsId->toArray()->willReturn([3]);

        $token->getUser()->willReturn($user);
        $user->getTags()->willReturn($userTags);

        $entityTags->add($tagPrivate);
        $entityTags->map(Argument::any())->willReturn($entityTagsId);
        $entityTagsId->toArray()->willReturn([4]);
        $taggable->getTags()->willReturn($entityTags);

        $this->vote($token, $taggable, [TaggedEntityVoter::VIEW])->shouldReturn(VoterInterface::ACCESS_DENIED);
    }

    function it_does_not_grant_tag_view_if_user_is_not_taggable(
        TokenInterface $token,
        UserInterface $user,
        TaggableInterface $taggable
    ) {
        $token->getUser()->willReturn($user);

        $this->vote($token, $taggable, [TaggedEntityVoter::VIEW])->shouldReturn(VoterInterface::ACCESS_DENIED);
    }

    function it_supports_only_taggable_entity(
        TokenInterface $token,
        \DateTime $dateTime
    ) {
        $this->vote($token, $dateTime, [TaggedEntityVoter::VIEW])->shouldReturn(VoterInterface::ACCESS_ABSTAIN);
    }

    function it_supports_only_view_attribute(
        TokenInterface $token,
        TaggableInterface $taggable
    ) {
        $this->vote($token, $taggable, ['other'])->shouldReturn(VoterInterface::ACCESS_ABSTAIN);
    }
}
