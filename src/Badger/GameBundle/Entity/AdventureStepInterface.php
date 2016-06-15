<?php

namespace Badger\GameBundle\Entity;

/**
 * Adventure Step interface
 *
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
     * @return bool
     */
    public function needProof();

    /**
     * @param bool $needProof
     *
     * @return BadgeInterface
     */
    public function setNeedProof($needProof);

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
}
