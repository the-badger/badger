<?php

namespace Badger\Component\Tag\Factory;

use Badger\TagBundle\Entity\Tag;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface TagFactoryInterface
{
    /**
     * Create a Tag instance.
     *
     * @return Tag
     */
    public function create();
}
