<?php

namespace Badger\Bundle\GameBundle\Entity;

use Badger\Component\Game\Model\BadgeCompletionInterface;
use Badger\Component\User\Model\UserInterface;

/**
 * Vote
 *
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class Vote
{
    /** @var int */
    private $id;

    /** @var UserInterface */
    protected $user;

    /** @var VotableItem */
    protected $votableItem;

    /**
     * @return VotableItem
     */
    public function getVotableItem()
    {
        return $this->votableItem;
    }

    /**
     * @param VotableItem $votableItem
     */
    public function setVotableItem($votableItem)
    {
        $this->votableItem = $votableItem;
    }

    /** @var int */
    protected $vote;

    public function __construct()
    {
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * @param int $vote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;
    }
}
