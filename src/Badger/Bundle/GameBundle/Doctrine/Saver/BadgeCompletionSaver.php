<?php

namespace Badger\Bundle\GameBundle\Doctrine\Saver;

use Badger\Bundle\GameBundle\GameEvents;
use Badger\Component\StorageUtils\Saver\SaverInterface;
use Badger\Bundle\GameBundle\Event\BadgeUnlockEvent;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Acl\Util\ClassUtils;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class BadgeCompletionSaver implements SaverInterface
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
    public function save($badgeCompletion, array $options = [])
    {
        if (false === ($badgeCompletion instanceof $this->savedClass)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expects a "%s", "%s" provided.',
                    $this->savedClass,
                    ClassUtils::getRealClass($badgeCompletion)
                )
            );
        }

        $this->objectManager->persist($badgeCompletion);
        $this->objectManager->flush();

        if (!$badgeCompletion->isPending()) {
            $event = new BadgeUnlockEvent($badgeCompletion);
            $this->eventDispatcher->dispatch(GameEvents::USER_UNLOCKS_BADGE, $event);
        }
    }
}
