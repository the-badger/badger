<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\ClaimedBadge;
use Badger\UserBundle\Entity\User;
use Badger\GameBundle\Entity\Badge;

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
