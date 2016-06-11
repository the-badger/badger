<?php

namespace Badger\GameBundle\Entity;

/**
 * Step interface
 *
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
     * @return AdventureInterface
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
     * @param BadgeInterface $badge
     *
     * @return AdventureInterface
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
