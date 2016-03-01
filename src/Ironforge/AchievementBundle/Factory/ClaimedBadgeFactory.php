<?php

namespace Ironforge\AchievementBundle\Factory;

use Ironforge\AchievementBundle\Entity\ClaimedBadge;
use Ironforge\UserBundle\Entity\User;
use Ironforge\AchievementBundle\Entity\Badge;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class ClaimedBadgeFactory implements ClaimedBadgeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(User $user, Badge $badge)
    {
        $claimedBadge = new ClaimedBadge();

        $claimedBadge->setUser($user);
        $claimedBadge->setBadge($badge);
        $claimedBadge->setClaimedDate(new \DateTime());

        return $claimedBadge;
    }
}
