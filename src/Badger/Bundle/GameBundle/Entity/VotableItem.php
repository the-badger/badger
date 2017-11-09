<?php

namespace Badger\Bundle\GameBundle\Entity;

use Badger\Component\Game\Model\BadgeCompletionInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contains the item to vote on.
 *
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class VotableItem
{
    /** @var int */
    private $id;

    /** @var BadgeCompletionInterface */
    private $badgeCompletion;

    /** @var Bool */
    private $pending = true;

    /** @var ArrayCollection */
    private $votes;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return BadgeCompletionInterface
     */
    public function getBadgeCompletion()
    {
        return $this->badgeCompletion;
    }

    /**
     * @param BadgeCompletionInterface $badgeCompletion
     */
    public function setBadgeCompletion($badgeCompletion)
    {
        $this->badgeCompletion = $badgeCompletion;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->pending;
    }

    /**
     * @param bool $pending
     */
    public function setPending($pending)
    {
        $this->pending = $pending;
    }

    /**
     * @return ArrayCollection
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @param ArrayCollection $votes
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;
    }
}
