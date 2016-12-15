<?php

namespace Badger\GameBundle\Doctrine\Saver;

use Doctrine\Common\Persistence\ObjectManager;
use Badger\StorageUtilsBundle\Saver\SaverInterface;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class RefusedHistorySaver implements SaverInterface
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
    public function save($refusedHistory, array $options = [])
    {
        if (false === ($refusedHistory instanceof $this->savedClass)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expects a "%s", "%s" provided.',
                    $this->savedClass,
                    ClassUtils::getRealClass($refusedHistory)
                )
            );
        }

        $this->objectManager->persist($refusedHistory);
        $this->objectManager->flush();
    }
}
