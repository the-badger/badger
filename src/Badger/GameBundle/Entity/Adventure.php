<?php

namespace Badger\GameBundle\Entity;

use Badger\TagBundle\Entity\TagInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Adventure
 *
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Adventure implements AdventureInterface
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

    /** @var ArrayCollection */
    private $tags;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
    }

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
    public function setIsStepLinked($isStepLinked)
    {
        $this->isStepLinked = $isStepLinked;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isStepLinked()
    {
        return $this->isStepLinked;
    }

    /**
     * {@inheritdoc}
     */
    public function setBadge(Badge $badge)
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
    public function addStep(AdventureStepInterface $step)
    {
        $step->setAdventure($this);
        $this->steps[] = $step;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeStep(AdventureStepInterface $step)
    {
        $this->steps->removeElement($step);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSteps($steps)
    {
        foreach ($steps as $step) {
            $this->addStep($step);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * {@inheritdoc}
     */
    public function setTags(ArrayCollection $tags)
    {
        $this->tags = $tags;
    }

    /**
     * {@inheritdoc}
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * {@inheritdoc}
     */
    public function addTag(TagInterface $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * @return int
     */
    public function countAllNuts()
    {
        $nuts = $this->getRewardPoint();

        foreach ($this->steps as $step) {
            $nuts += $step->getRewardPoint();
        }

        return $nuts;
    }

    /**
     * @return int
     */
    public function countAllBadges()
    {
        $badgesCount = (null === $this->getBadge()) ? 0 : 1;

        foreach ($this->steps as $step) {
            $badgesCount += (null === $step->getBadge()) ? 0 : 1;
        }

        return $badgesCount;
    }
}

