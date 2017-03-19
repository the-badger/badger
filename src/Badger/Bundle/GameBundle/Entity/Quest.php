<?php

namespace Badger\Bundle\GameBundle\Entity;

use Badger\Component\Game\Model\QuestInterface;
use Badger\Component\Game\Model\TagInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Quest entity.
 *
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class Quest implements QuestInterface
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $title;

    /** @var string */
    protected $description;

    /** @var int */
    protected $reward;

    /** @var \DateTime */
    protected $startDate;

    /** @var \DateTime */
    protected $endDate;

    /** @var ArrayCollection */
    protected $tags;

    /** @var ArrayCollection */
    protected $completions;

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
    public function getTitle()
    {
        return $this->title;
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
    public function getDescription()
    {
        return $this->description;
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
    public function getReward()
    {
        return $this->reward;
    }

    /**
     * {@inheritdoc}
     */
    public function setReward($reward)
    {
        $this->reward = $reward;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
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

    /**
     * {@inheritdoc}
     */
    public function getApprovedCompletionsCount()
    {
        return $this->completions->filter(function($completion) {
            return !$completion->isPending();
        })->count();
    }
}
