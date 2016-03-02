<?php

namespace Ironforge\StorageUtilsBundle\Saver;

/**
 * Saver interface, provides a minimal contract to save a single business object
 *
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
interface SaverInterface
{
    /**
     * Save a single object
     *
     * @param mixed $object  The object to save
     * @param array $options The saving options
     *
     * @throws \InvalidArgumentException
     */
    public function save($object, array $options = []);
}
