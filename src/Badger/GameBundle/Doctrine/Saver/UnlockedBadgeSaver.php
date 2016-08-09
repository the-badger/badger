<?php

namespace Badger\GameBundle\Doctrine\Saver;

use Doctrine\Common\Persistence\ObjectManager;
use Badger\GameBundle\GameEvents;
use Badger\GameBundle\Event\BadgeUnlockEvent;
use Badger\StorageUtilsBundle\Saver\SaverInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Acl\Util\ClassUtils;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
