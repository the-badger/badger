<?php

namespace Badger\TagBundle\Entity;

use Badger\GameBundle\Entity\AdventureInterface;
use Badger\GameBundle\Entity\BadgeInterface;
use Badger\GameBundle\Entity\QuestInterface;

/**
 * Tag entity.
 *
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Tag implements TagInterface
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $code;

    /** @var bool */
    protected $isDefault;

    /** @var \DateTime */
    protected $createdAt;

    /** @var BadgeInterface[] */
    protected $badges;

    /** @var QuestInterface[] */
    protected $quests;

    /** @var AdventureInterface[] */
    protected $adventures;

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
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isDefault()
    {
        return $this->isDefault;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getBadges()
    {
        return $this->badges;
    }

    /**
     * {@inheritdoc}
     */
    public function setBadges(array $badges)
    {
        $this->badges = $badges;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuests()
    {
        return $this->quests;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuests(array $quests)
    {
        $this->quests = $quests;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdventures()
    {
        return $this->adventures;
    }

    /**
     * {@inheritdoc}
     */
    public function setAdventures($adventures)
    {
        $this->adventures = $adventures;
    }

    public function __toString()
    {
        return $this->name;
    }
}
