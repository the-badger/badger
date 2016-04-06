<?php

namespace Badger\GameBundle\Entity;

/**
 * Step interface
 *
 * @author Marie Bochu <marie.bochu@akeneo.com>
 */
interface StepInterface
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
     * @return StepInterface
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
     * @return Adventure
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
     * @return StepInterface
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
     * @return StepInterface
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
     * @param Badge $badge
     *
     * @return Adventure
     */
    public function setBadge(Badge $badge);

    /**
     * Get badge
     *
     * @return Badge
     */
    public function getBadge();

    /**
     * Set adventure
     *
     * @param AdventureInterface $adventure
     *
     * @return StepInterface
     */
    public function setAdventure(AdventureInterface $adventure);

    /**
     * Get adventure
     *
     * @return AdventureInterface
     */
    public function getAdventure();
}
