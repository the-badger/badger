<?php

namespace spec\Badger\StorageUtilsBundle\Doctrine\Saver;

use Badger\GameBundle\Entity\Badge;
use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;

class BaseSaverSpec extends ObjectBehavior
{
    function let(ObjectManager $objectManager)
    {
        $this->beConstructedWith($objectManager, 'Badger\GameBundle\Entity\Badge');
    }

    function it_is_a_saver()
    {
        $this->shouldHaveType('Badger\StorageUtilsBundle\Saver\SaverInterface');
    }

    function it_persists_the_object_and_flushes_the_unit_of_work($objectManager, Badge $type)
    {
        $objectManager->persist($type)->shouldBeCalled();
        $objectManager->flush()->shouldBeCalled();

        $this->save($type);
    }

    function it_throws_exception_when_save_anything_else_than_the_expected_class($optionsResolver)
    {
        $anythingElse = new \stdClass();
        $exception = new \InvalidArgumentException(
            sprintf(
                'Expects a "Badger\GameBundle\Entity\Badge", "%s" provided.',
                get_class($anythingElse)
            )
        );
        $this->shouldThrow($exception)->during('save', [$anythingElse]);
    }
}
