<?php

namespace Ironforge\GameBundle\Factory;

use Ironforge\GameBundle\Entity\Badge;

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
