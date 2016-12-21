<?php

namespace Badger\Component\Game\Factory;

/**
* Factory interface
*
* @author  Olivier Soulet <olivier.soulet@akeneo.com>
* @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
