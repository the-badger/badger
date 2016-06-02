<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\BadgeInterface;
use Badger\GameBundle\Entity\UnlockedBadge;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class UnlockedBadgeFactory implements UnlockedBadgeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(UserInterface $user, BadgeInterface $badge)
    {
        $unlockedBadge = new UnlockedBadge();

        $unlockedBadge->setUser($user);
        $unlockedBadge->setBadge($badge);
        $unlockedBadge->setUnlockedDate(new \DateTime());

        return $unlockedBadge;
    }
}
