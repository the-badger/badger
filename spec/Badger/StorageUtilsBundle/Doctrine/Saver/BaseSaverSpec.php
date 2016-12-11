<?php

namespace spec\Badger\StorageUtilsBundle\Doctrine\Saver;

use Badger\Component\Game\Model\BadgeInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;

class BaseSaverSpec extends ObjectBehavior
{
    function let(ObjectManager $objectManager)
    {
        $this->beConstructedWith($objectManager, 'Badger\Component\Game\Model\BadgeInterface');
    }

    function it_is_a_saver()
    {
        $this->shouldHaveType('Badger\StorageUtilsBundle\Saver\SaverInterface');
    }

    function it_persists_the_object_and_flushes_the_unit_of_work($objectManager, BadgeInterface $type)
    {
        $objectManager->persist($type)->shouldBeCalled();
        $objectManager->flush()->shouldBeCalled();

        $this->save($type);
    }

    function it_throws_exception_when_save_anything_else_than_the_expected_class()
    {
        $anythingElse = new \stdClass();
        $exception = new \InvalidArgumentException(
            sprintf(
                'Expects a "Badger\Component\Game\Model\BadgeInterface", "%s" provided.',
                get_class($anythingElse)
            )
        );
        $this->shouldThrow($exception)->during('save', [$anythingElse]);
    }
}
