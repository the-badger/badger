<?php

namespace Badger\TagBundle\Entity;

use Badger\Component\Game\Model\AdventureInterface;
use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\Game\Model\QuestInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface TagInterface
{
    /**
     * Get id
     *
     * @return int
     */
    public function getId();

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TagInterface
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set code
     *
     * @param string $code
     *
     * @return TagInterface
     */
    public function setCode($code);

    /**
     * Get code
     *
     * @return string
     */
    public function getCode();

    /**
     * @param bool $isDefault
     *
     * @return TagInterface
     */
    public function setIsDefault($isDefault);

    /**
     * @return bool
     */
    public function isDefault();

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return TagInterface
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return BadgeInterface[]
     */
    public function getBadges();

    /**
     * @param BadgeInterface[] $badges
     */
    public function setBadges(array $badges);

    /**
     * @return QuestInterface[]
     */
    public function getQuests();

    /**
     * @param QuestInterface[] $quests
     */
    public function setQuests(array $quests);

    /**
     * @return AdventureInterface[]
     */
    public function getAdventures();

    /**
     * @param AdventureInterface[] $adventures
     */
    public function setAdventures($adventures);
}
