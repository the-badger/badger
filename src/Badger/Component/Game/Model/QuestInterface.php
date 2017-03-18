<?php

namespace Badger\Component\Game\Model;

use Badger\Component\Game\Taggable\TaggableInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Quest entity interface
 *
 * @author  Pierre Allard <pierre.allard@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface QuestInterface extends TaggableInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     *
     * @return QuestInterface
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     *
     * @return QuestInterface
     */
    public function setDescription($description);

    /**
     * @return int
     */
    public function getReward();

    /**
     * @param int $reward
     *
     * @return QuestInterface
     */
    public function setReward($reward);

    /**
     * @return \DateTime
     */
    public function getStartDate();

    /**
     * @param \DateTime $startDate
     *
     * @return QuestInterface
     */
    public function setStartDate($startDate);

    /**
     * @return \DateTime
     */
    public function getEndDate();

    /**
     * @param \DateTime $endDate
     *
     * @return QuestInterface
     */
    public function setEndDate($endDate);

    /**
     * @return ArrayCollection
     */
    public function getCompletions();

    /**
     * @param ArrayCollection $completions
     */
    public function setCompletions($completions);

    /**
     * Return the count of approved completions for this quest
     *
     * @return int
     */
    public function getApprovedCompletionsCount();
}
