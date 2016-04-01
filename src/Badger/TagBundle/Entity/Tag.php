<?php

namespace Badger\TagBundle\Entity;

use Badger\GameBundle\Entity\Badge;

/**
 * Tag entity.
 */
class Tag implements TagInterface
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $code;

    /** @var \DateTime */
    private $createdAt;

    /** @var Badge[] */
    private $badges;

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
}

