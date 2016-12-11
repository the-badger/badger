<?php

namespace Badger\StorageUtilsBundle\Remover;

/**
 * Remover interface, provides a minimal contract to remove a single business object
 *
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface RemoverInterface
{
    /**
     * Delete a single object
     *
     * @param mixed $object  The object to delete
     * @param array $options The delete options
     *
     * @throws \InvalidArgumentException
     */
    public function remove($object, array $options = []);
}
