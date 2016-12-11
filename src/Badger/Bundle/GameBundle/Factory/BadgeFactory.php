<?php

namespace Badger\GameBundle\Factory;

use Badger\Component\Game\Factory\SimpleFactoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Badger\GameBundle\Entity\Badge;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class BadgeFactory implements SimpleFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $badge = new Badge();
        $badge->setTags(new ArrayCollection());

        return $badge;
    }
}
