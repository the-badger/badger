<?php

namespace Badger\GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Adventure interface
 *
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface AdventureInterface
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
     * @return AdventureInterface
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
     * Set rewardPoint
     *
     * @param int $rewardPoint
     *
     * @return AdventureInterface
     */
    public function setRewardPoint($rewardPoint);

    /**
     * Get rewardPoint
     *
     * @return int
     */
    public function getRewardPoint();

    /**
     * Set isStepLinked
     *
     * @param bool $isStepLinked
     *
     * @return AdventureInterface
     */
    public function setIsStepLinked($isStepLinked);

    /**
     * Get isStepLinked
     *
     * @return bool
     */
    public function isStepLinked();

    /**
     * Set badge
     *
     * @param Badge $badge
     *
     * @return AdventureInterface
     */
    public function setBadge(Badge $badge);

    /**
     * Get badge
     *
     * @return Badge
     */
    public function getBadge();

    /**
     * @param StepInterface $step
     *
     * @return AdventureInterface
     */
    public function addStep(StepInterface $step);

    /**
     * @param StepInterface $step
     *
     * @return AdventureInterface
     */
    public function removeStep(StepInterface $step);

    /**
     * @param array $steps
     *
     * @return AdventureInterface
     */
    public function setSteps($steps);

    /**
     * @return ArrayCollection
     */
    public function getSteps();
}

