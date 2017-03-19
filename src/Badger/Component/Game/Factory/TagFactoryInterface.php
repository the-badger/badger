<?php

namespace Badger\Component\Game\Factory;

use Badger\Component\Game\Model\TagInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface TagFactoryInterface
{
    /**
     * Create a Tag instance.
     *
     * @return TagInterface
     */
    public function create();
}
