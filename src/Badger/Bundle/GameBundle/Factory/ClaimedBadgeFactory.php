<?php

namespace Badger\GameBundle\Factory;

use Badger\Component\Game\Factory\ClaimedBadgeFactoryInterface;
use Badger\Component\Game\Model\BadgeInterface;
use Badger\GameBundle\Entity\ClaimedBadge;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class ClaimedBadgeFactory implements ClaimedBadgeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(UserInterface $user, BadgeInterface $badge)
    {
        $claimedBadge = new ClaimedBadge();

        $claimedBadge->setUser($user);
        $claimedBadge->setBadge($badge);
        $claimedBadge->setClaimedDate(new \DateTime());

        return $claimedBadge;
    }
}
