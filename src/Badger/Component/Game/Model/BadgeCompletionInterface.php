<?php

namespace Badger\Component\Game\Model;

use Badger\Component\User\Model\UserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface BadgeCompletionInterface
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
     * @return UserInterface
     */
    public function getUser();

    /**
     * @param UserInterface $user
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
    public function getCompletionDate();

    /**
     * @param \DateTime $unlockedDate
     */
    public function setCompletionDate(\DateTime $unlockedDate);

    /**
     * @return boolean
     */
    public function isPending();

    /**
     * @param boolean $pending
     */
    public function setPending($pending);
}
