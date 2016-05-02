<?php

namespace Badger\StorageUtilsBundle\Doctrine\Remover;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\ClassUtils;
use Badger\StorageUtilsBundle\Remover\RemoverInterface;

/**
 * Base remover, declared as different services for different classes
 *
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BaseRemover implements RemoverInterface
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var string */
    protected $removedClass;

    /**
     * @param ObjectManager $objectManager
     * @param string        $removedClass
     */
    public function __construct(ObjectManager $objectManager, $removedClass)
    {
        $this->objectManager = $objectManager;
        $this->removedClass = $removedClass;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($object, array $options = [])
    {
        if (false === ($object instanceof $this->removedClass)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expects a "%s", "%s" provided.',
                    $this->removedClass,
                    ClassUtils::getClass($object)
                )
            );
        }

        $this->objectManager->remove($object);
        $this->objectManager->flush();
    }
}
