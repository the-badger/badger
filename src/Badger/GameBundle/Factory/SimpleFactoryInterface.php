<?php

namespace Badger\GameBundle\Factory;

/**
* Factory interface
*
* @author    Olivier Soulet <olivier.soulet@akeneo.com>
* @copyright 2016 Akeneo SAS (http://www.akeneo.com)
* @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/
interface SimpleFactoryInterface
{
    /**
     * Create an instance.
     *
     * @return Object
     */
    public function create();
}
