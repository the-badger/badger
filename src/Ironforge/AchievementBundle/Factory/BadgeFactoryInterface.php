<?php

namespace Ironforge\AchievementBundle\Factory;

use Ironforge\AchievementBundle\Entity\Badge;

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
