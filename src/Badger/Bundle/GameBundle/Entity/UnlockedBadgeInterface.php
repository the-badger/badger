<?php

namespace Badger\GameBundle\Entity;

use Badger\UserBundle\Entity\User;

/**
 * Unlocked badges entity interface
 *
 * @author  Pierre Allard <pierre.allard@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface UnlockedBadgeInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $id
     */
    public function setId($id);

    /**
     * @return User
     */
    public function getUser();

    /**
     * @param User $user
     */
    public function setUser($user);

    /**
     * @return BadgeInterface
     */
    public function getBadge();

    /**
     * @param BadgeInterface $badge
     */
    public function setBadge($badge);

    /**
     * @return \DateTime
     */
    public function getUnlockedDate();

    /**
     * @param \DateTime $unlockedDate
     */
    public function setUnlockedDate(\DateTime $unlockedDate);
}
