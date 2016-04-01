<?php

namespace Badger\GameBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Badger\GameBundle\Entity\Badge;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class BadgeFactory implements BadgeFactoryInterface
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
