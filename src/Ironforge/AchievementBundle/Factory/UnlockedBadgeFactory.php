<?php

namespace Ironforge\AchievementBundle\Factory;

use Ironforge\AchievementBundle\Entity\Badge;
use Ironforge\AchievementBundle\Entity\UnlockedBadge;
use Ironforge\UserBundle\Entity\User;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class UnlockedBadgeFactory implements UnlockedBadgeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(User $user, Badge $badge)
    {
        $unlockedBadge = new UnlockedBadge();

        $unlockedBadge->setUser($user);
        $unlockedBadge->setBadge($badge);
        $unlockedBadge->setUnlockedDate(new \DateTime());

        return $unlockedBadge;
    }
}
