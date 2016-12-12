<?php

namespace spec\Badger\UserBundle\Normalizer;

use Badger\Component\Tag\Model\TagInterface;
use Badger\UserBundle\Entity\User;
use PhpSpec\ObjectBehavior;

class UserNormalizerSpec extends ObjectBehavior
{
    function it_is_a_normalizer()
    {
        $this->shouldImplement('Symfony\Component\Serializer\Normalizer\NormalizerInterface');
    }

    function it_supports_user_normalization(
        User $user,
        TagInterface $tag
    ) {
        $this->supportsNormalization($user, 'json')->shouldReturn(true);

        $this->supportsNormalization($user, 'xml')->shouldReturn(false);
        $this->supportsNormalization($tag, 'json')->shouldReturn(false);
    }

    function it_normalizes_a_user(
        User $user,
        TagInterface $tag1,
        TagInterface $tag2
    ) {
        $user->getId()->willReturn(42);
        $user->getUsername()->willReturn('Bender');
        $user->getProfilePicture()->willReturn('bender.png');
        $user->getTags()->willReturn([$tag1, $tag2]);

        $tag1->getName()->willReturn('Community');
        $tag2->getName()->willReturn('Developer');

        $this->normalize($user, 'json')->shouldReturn([
            'id'             => 42,
            'username'       => 'Bender',
            'profilePicture' => 'bender.png',
            'tags'           => ['Community', 'Developer'],
        ]);
    }
}
