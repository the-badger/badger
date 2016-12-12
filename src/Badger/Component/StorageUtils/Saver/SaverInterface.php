<?php

namespace Badger\Component\StorageUtils\Saver;

/**
 * Saver interface, provides a minimal contract to save a single business object
 *
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
