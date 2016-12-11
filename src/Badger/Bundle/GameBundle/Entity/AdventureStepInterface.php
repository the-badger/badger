<?php

namespace Badger\GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Adventure Step interface
 *
 * @author  Marie Bochu <marie.bochu@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface AdventureStepInterface
{
    /**
     * Get id
     *
     * @return int
     */
    public function getId();

    /**
     * Set title
     *
     * @param string $title
     *
     * @return AdventureStepInterface
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set description
     *
     * @param string $description
     *
     * @return AdventureStepInterface
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set position
     *
     * @param int $position
     *
     * @return AdventureStepInterface
     */
    public function setPosition($position);

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition();

    /**
     * Set rewardPoint
     *
     * @param int $rewardPoint
     *
     * @return AdventureStepInterface
     */
    public function setRewardPoint($rewardPoint);

    /**
     * Get rewardPoint
     *
     * @return int
     */
    public function getRewardPoint();

    /**
     * Set badge
     *
     * @param BadgeInterface $badge
     *
     * @return AdventureStepInterface
     */
    public function setBadge(BadgeInterface $badge);

    /**
     * Get badge
     *
     * @return BadgeInterface
     */
    public function getBadge();

    /**
     * Set adventure
     *
     * @param AdventureInterface $adventure
     *
     * @return AdventureStepInterface
     */
    public function setAdventure(AdventureInterface $adventure);

    /**
     * Get adventure
     *
     * @return AdventureInterface
     */
    public function getAdventure();

    /**
     * @return ArrayCollection
     */
    public function getCompletions();

    /**
     * @param ArrayCollection $completions
     */
    public function setCompletions($completions);
}
