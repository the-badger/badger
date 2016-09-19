<?php

namespace Badger\GameBundle\Entity;

use Badger\TagBundle\Taggable\TaggableInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Adventure interface
 *
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface AdventureInterface extends TaggableInterface
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
     * @param BadgeInterface $badge
     *
     * @return AdventureInterface
     */
    public function setBadge(BadgeInterface $badge);

    /**
     * Get badge
     *
     * @return BadgeInterface|null
     */
    public function getBadge();

    /**
     * @param AdventureStepInterface $step
     *
     * @return AdventureInterface
     */
    public function addStep(AdventureStepInterface $step);

    /**
     * @param AdventureStepInterface $step
     *
     * @return AdventureInterface
     */
    public function removeStep(AdventureStepInterface $step);

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

