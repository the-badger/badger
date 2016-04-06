<?php

namespace Badger\GameBundle\Entity;

/**
 * Step
 */
class Step
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var int */
    private $position;

    /** @var int */
    private $rewardPoint;

    /** @var Badge */
    private $badge;

    /** @var Adventure */
    private $adventure;

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
     * @return Step
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
     * Set position
     *
     * @param integer $position
     *
     * @return Step
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set rewardPoint
     *
     * @param integer $rewardPoint
     *
     * @return Step
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
     * Set adventure
     *
     * @param Adventure $adventure
     *
     * @return Step
     */
    public function setAdventure(Adventure $adventure)
    {
        $this->adventure = $adventure;

        return $this;
    }

    /**
     * Get adventure
     *
     * @return Adventure
     */
    public function getAdventure()
    {
        return $this->adventure;
    }
}

