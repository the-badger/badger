<?php

namespace Ironforge\TagBundle\Factory;

use Ironforge\TagBundle\Entity\Tag;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
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
