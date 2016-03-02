<?php

namespace Ironforge\AchievementBundle\Factory;

use Ironforge\AchievementBundle\Entity\Badge;

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
        return new Badge();
    }
}
