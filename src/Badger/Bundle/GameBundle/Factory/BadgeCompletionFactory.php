<?php

namespace Badger\Bundle\GameBundle\Factory;

use Badger\Bundle\GameBundle\Entity\BadgeCompletion;
use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\User\Model\UserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class BadgeCompletionFactory
{
    /**
     * @param UserInterface  $user
     * @param BadgeInterface $badge
     *
     * @return BadgeCompletion
     */
    public function create(UserInterface $user, BadgeInterface $badge)
    {
        $badgeCompletion = new BadgeCompletion();

        $badgeCompletion->setUser($user);
        $badgeCompletion->setBadge($badge);
        $badgeCompletion->setCompletionDate(new \DateTime());
        $badgeCompletion->setPending(true);

        return $badgeCompletion;
    }
}
