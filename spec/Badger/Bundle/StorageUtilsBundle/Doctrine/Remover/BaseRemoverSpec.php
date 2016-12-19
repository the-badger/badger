<?php

namespace spec\Badger\Bundle\StorageUtilsBundle\Doctrine\Remover;

use Badger\Component\Game\Model\BadgeInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;

class BaseRemoverSpec extends ObjectBehavior
{
    function let(ObjectManager $objectManager)
    {
        $this->beConstructedWith($objectManager, 'Badger\Component\Game\Model\BadgeInterface');
    }

    function it_is_a_remover()
    {
        $this->shouldHaveType('Badger\Component\StorageUtils\Remover\RemoverInterface');
    }

    function it_removes_the_object_and_flushes_the_unit_of_work($objectManager, BadgeInterface $type)
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
                'Expects a "Badger\Component\Game\Model\BadgeInterface", "%s" provided.',
                get_class($anythingElse)
            )
        );
        $this->shouldThrow($exception)->during('remove', [$anythingElse]);
    }
}
