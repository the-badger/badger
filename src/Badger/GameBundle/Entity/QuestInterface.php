<?php

namespace Badger\GameBundle\Entity;

use Badger\TagBundle\Taggable\TaggableInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Quest entity interface
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
     * @return $this
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description);

    /**
     * @return int
     */
    public function getReward();

    /**
     * @param int $reward
     *
     * @return Quest
     */
    public function setReward($reward);

    /**
     * @return \DateTime
     */
    public function getStartDate();

    /**
     * @param \DateTime $startDate
     *
     * @return Quest
     */
    public function setStartDate($startDate);

    /**
     * @return \DateTime
     */
    public function getEndDate();

    /**
     * @param \DateTime $endDate
     *
     * @return Quest
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
