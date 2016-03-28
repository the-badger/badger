<?php

namespace Ironforge\AchievementBundle\Entity;

use Ironforge\UserBundle\Entity\User;

/**
 * An ClaimedBadge is the entity that represents the user wanting a badge.
 *
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class ClaimedBadge
{
    /** @var string */
    protected $id;

    /** @var User */
    protected $user;

    /** @var Badge */
    protected $badge;

    /** @var \DateTime */
    protected $claimedDate;

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
     * @return \DateTime
     */
    public function getClaimedDate()
    {
        return $this->claimedDate;
    }

    /**
     * @param \DateTime $claimedDate
     */
    public function setClaimedDate($claimedDate)
    {
        $this->claimedDate = $claimedDate;
    }
}
