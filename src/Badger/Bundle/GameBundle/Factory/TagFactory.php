<?php

namespace Badger\Bundle\GameBundle\Factory;

use Badger\Bundle\GameBundle\Entity\Tag;
use Badger\Component\Game\Factory\TagFactoryInterface;

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
