<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Badge;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
interface BadgeFactoryInterface
{
    /**
     * Create a Badge instance.
     *
     * @return Badge
     */
    public function create();
}
