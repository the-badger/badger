<?php

namespace Badger\StorageUtilsBundle\Doctrine\Saver;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\ClassUtils;
use Badger\StorageUtilsBundle\Saver\SaverInterface;

/**
 * Base saver, declared as different services for different classes
 *
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BaseSaver implements SaverInterface
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var string */
    protected $savedClass;

    /**
     * @param ObjectManager $objectManager
     * @param string        $savedClass
     */
    public function __construct(ObjectManager $objectManager, $savedClass)
    {
        $this->objectManager = $objectManager;
        $this->savedClass = $savedClass;
    }

    /**
     * {@inheritdoc}
     */
    public function save($object, array $options = [])
    {
        if (false === ($object instanceof $this->savedClass)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expects a "%s", "%s" provided.',
                    $this->savedClass,
                    ClassUtils::getClass($object)
                )
            );
        }

        $this->objectManager->persist($object);
        $this->objectManager->flush();
    }
}
