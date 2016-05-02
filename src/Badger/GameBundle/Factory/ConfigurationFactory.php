<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Configuration;

/**
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
