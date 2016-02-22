<?php

namespace Ironforge\AchievementBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Ironforge\AchievementBundle\Entity\Badge;
use Ironforge\UserBundle\Entity\User;

/**
 * @author Adrien Pétremann <petremann.adrien@gmail.com>
 */
class UnlockedBadgeRepository extends EntityRepository
{
    /**
     * Retrieves unlocked badges for the given user
     *
     * @param User $user
     *
     * @return Badge[]
     */
    public function getUserUnlockedBadges(User $user)
    {
        $badges = [];
        $unlocks = $this->findBy(['user' => $user]);
        foreach ($unlocks as $unlock) {
            $badges[] = $unlock->getBadge();
        }

        return $badges;
    }
}
