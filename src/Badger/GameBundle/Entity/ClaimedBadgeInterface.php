<?php

namespace Badger\GameBundle\Entity;

use Badger\UserBundle\Entity\User;

/**
 * ClaimedBadgeInterface to describe claimed badges
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface ClaimedBadgeInterface
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
    public function getClaimedDate();

    /**
     * @param \DateTime $claimedDate
     */
    public function setClaimedDate($claimedDate);

    /**
     * @return string
     */
    public function getProof();

    /**
     * @param string $proof
     */
    public function setProof($proof);
}
