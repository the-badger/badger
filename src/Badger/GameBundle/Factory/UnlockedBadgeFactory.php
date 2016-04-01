<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Badge;
use Badger\GameBundle\Entity\UnlockedBadge;
use Badger\UserBundle\Entity\User;

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
