<?php

namespace spec\Badger\StorageUtilsBundle\Doctrine\Remover;

use Badger\GameBundle\Entity\Badge;
use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;

class BaseRemoverSpec extends ObjectBehavior
{
    function let(ObjectManager $objectManager)
    {
        $this->beConstructedWith($objectManager, 'Badger\GameBundle\Entity\Badge');
    }

    function it_is_a_remover()
    {
        $this->shouldHaveType('Badger\StorageUtilsBundle\Remover\RemoverInterface');
    }

    function it_removes_the_object_and_flushes_the_unit_of_work($objectManager, Badge $type)
    {
        $objectManager->remove($type)->shouldBeCalled();
        $objectManager->flush()->shouldBeCalled();
        $this->remove($type);
    }

    function it_throws_exception_when_remove_anything_else_than_the_expected_class()
    {
        $anythingElse = new \stdClass();
        $exception = new \InvalidArgumentException(
            sprintf(
                'Expects a "Badger\GameBundle\Entity\Badge", "%s" provided.',
                get_class($anythingElse)
            )
        );
        $this->shouldThrow($exception)->during('remove', [$anythingElse]);
    }
}
