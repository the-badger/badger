<?php

namespace Ironforge\AchievementBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Ironforge\AchievementBundle\Entity\Badge;
use Ironforge\UserBundle\Entity\User;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
