<?php

namespace Badger\Bundle\TagBundle\Factory;

use Badger\Component\Tag\Factory\TagFactoryInterface;
use Badger\Bundle\TagBundle\Entity\Tag;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
