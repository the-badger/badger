<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Configuration;

/**
 * @author Marie Bochu <marie.bochu@akeneo.com>
 */
class ConfigurationFactory
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new Configuration();
    }
}
