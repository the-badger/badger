<?php

namespace Badger\GameBundle\Entity;

use Badger\UserBundle\Entity\User;

/**
 * An ClaimedBadge is the entity that represents the user wanting a badge.
 *
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class ClaimedBadge implements ClaimedBadgeInterface
{
    /** @var string */
    protected $id;

    /** @var User */
    protected $user;

    /** @var BadgeInterface */
    protected $badge;

    /** @var \DateTime */
    protected $claimedDate;

    /** @var string */
    protected $proof;

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
    public function getClaimedDate()
    {
        return $this->claimedDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setClaimedDate($claimedDate)
    {
        $this->claimedDate = $claimedDate;
    }

    /**
     * {@inheritdoc}
     */
    public function getProof()
    {
        return $this->proof;
    }

    /**
     * {@inheritdoc}
     */
    public function setProof($proof)
    {
        $this->proof = $proof;
    }
}
