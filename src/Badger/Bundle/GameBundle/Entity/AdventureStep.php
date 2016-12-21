<?php

namespace Badger\Bundle\GameBundle\Entity;

use Badger\Component\Game\Model\AdventureInterface;
use Badger\Component\Game\Model\AdventureStepInterface;
use Badger\Component\Game\Model\BadgeInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Adventure Step
 *
 * @author  Marie Bochu <marie.bochu@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class AdventureStep implements AdventureStepInterface
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

    /** @var ArrayCollection */
    private $completions;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function setRewardPoint($rewardPoint)
    {
        $this->rewardPoint = $rewardPoint;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRewardPoint()
    {
        return $this->rewardPoint;
    }

    /**
     * {@inheritdoc}
     */
    public function setBadge(BadgeInterface $badge)
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * {@inheritdoc}
     */
    public function setAdventure(AdventureInterface $adventure)
    {
        $this->adventure = $adventure;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdventure()
    {
        return $this->adventure;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompletions()
    {
        return $this->completions;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompletions($completions)
    {
        $this->completions = $completions;
    }
}

