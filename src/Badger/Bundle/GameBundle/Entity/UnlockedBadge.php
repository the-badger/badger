<?php

namespace Badger\GameBundle\Entity;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\Game\Model\UnlockedBadgeInterface;
use Badger\UserBundle\Entity\User;

/**
 * An UnlockedBadge is the entity that represents the user having a badge.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class UnlockedBadge implements UnlockedBadgeInterface
{
    /** @var string */
    protected $id;

    /** @var User */
    protected $user;

    /** @var BadgeInterface */
    protected $badge;

    /** @var \DateTime */
    protected $unlockedDate;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * {@inheritdoc}
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnlockedDate()
    {
        return $this->unlockedDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setUnlockedDate(\DateTime $unlockedDate)
    {
        $this->unlockedDate = $unlockedDate;
    }
}
