<?php

namespace Badger\Bundle\GameBundle\Doctrine\Saver;

use Badger\Bundle\GameBundle\Event\BadgeUnlockEvent;
use Badger\Bundle\GameBundle\GameEvents;
use Badger\Component\StorageUtils\Saver\SaverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Acl\Util\ClassUtils;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class UnlockedBadgeSaver implements SaverInterface
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var string */
    protected $savedClass;

    /**
     * @param ObjectManager            $objectManager
     * @param EventDispatcherInterface $eventDispatcher
     * @param string                   $savedClass
     */
    public function __construct(
        ObjectManager $objectManager,
        EventDispatcherInterface $eventDispatcher,
        $savedClass
    ) {
        $this->objectManager   = $objectManager;
        $this->savedClass      = $savedClass;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function save($unlockedBadge, array $options = [])
    {
        if (false === ($unlockedBadge instanceof $this->savedClass)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expects a "%s", "%s" provided.',
                    $this->savedClass,
                    ClassUtils::getRealClass($unlockedBadge)
                )
            );
        }

        $this->objectManager->persist($unlockedBadge);
        $this->objectManager->flush();

        $event = new BadgeUnlockEvent($unlockedBadge);
        $this->eventDispatcher->dispatch(GameEvents::USER_UNLOCKS_BADGE, $event);
    }
}
