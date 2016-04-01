<?php

namespace Badger\StorageUtilsBundle\Remover;

/**
 * Remover interface, provides a minimal contract to remove a single business object
 *
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
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
