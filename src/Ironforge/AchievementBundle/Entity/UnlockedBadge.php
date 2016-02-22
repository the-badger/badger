<?php

namespace Ironforge\AchievementBundle\Entity;

use Ironforge\UserBundle\Entity\User;

/**
 * An UnlockedBadge is the entity that represents the user having a badge.
 * 
 * @author Adrien Pétremann <petremann.adrien@gmail.com>
 */
class UnlockedBadge
{
    /** @var string */
    protected $id;

    /** @var User */
    protected $user;

    /** @var Badge */
    protected $badge;

    /** @var DateTime */
    protected $unlockedDate;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Badge
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * @param Badge $badge
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;
    }

    /**
     * @return DateTime
     */
    public function getUnlockedDate()
    {
        return $this->unlockedDate;
    }

    /**
     * @param DateTime $unlockedDate
     */
    public function setUnlockedDate($unlockedDate)
    {
        $this->unlockedDate = $unlockedDate;
    }
}
