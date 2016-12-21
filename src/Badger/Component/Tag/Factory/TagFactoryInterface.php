<?php

namespace Badger\Component\Tag\Factory;

use Badger\Component\Tag\Model\TagInterface;

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
