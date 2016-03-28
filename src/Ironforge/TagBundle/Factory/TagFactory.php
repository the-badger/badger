<?php

namespace Ironforge\TagBundle\Factory;

use Ironforge\TagBundle\Entity\Tag;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class TagFactory implements TagFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $tag = new Tag();
        $tag->setCreatedAt(new \DateTime());

        return $tag;
    }
}
