<?php

namespace Badger\GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Adventure
 */
class Adventure
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var int */
    private $rewardPoint;

    /** @var bool */
    private $isStepLinked;

    /** @var Badge */
    private $badge;

    /** @var ArrayCollection */
    private $steps;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Adventure
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Adventure
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set rewardPoint
     *
     * @param integer $rewardPoint
     *
     * @return Adventure
     */
    public function setRewardPoint($rewardPoint)
    {
        $this->rewardPoint = $rewardPoint;

        return $this;
    }

    /**
     * Get rewardPoint
     *
     * @return int
     */
    public function getRewardPoint()
    {
        return $this->rewardPoint;
    }

    /**
     * Set isStepLinked
     *
     * @param bool $isStepLinked
     *
     * @return Adventure
     */
    public function setIsStepLinked($isStepLinked)
    {
        $this->isStepLinked = $isStepLinked;

        return $this;
    }

    /**
     * Get isStepLinked
     *
     * @return bool
     */
    public function isStepLinked()
    {
        return $this->isStepLinked;
    }

    /**
     * Set badge
     *
     * @param Badge $badge
     *
     * @return Adventure
     */
    public function setBadge(Badge $badge)
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * Get badge
     *
     * @return Badge
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * @param Step $step
     *
     * @return Adventure
     */
    public function addStep(Step $step)
    {
        $step->setAdventure($this);
        $this->steps[] = $step;

        return $this;
    }

    /**
     * @param Step $step
     *
     * @return Adventure
     */
    public function removeStep(Step $step)
    {
        $this->steps->removeElement($step);

        return $this;
    }

    /**
     * @param array $steps
     *
     * @return Adventure
     */
    public function setSteps($steps)
    {
        foreach ($steps as $step) {
            $this->addStep($step);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSteps()
    {
        return $this->steps;
    }
}

