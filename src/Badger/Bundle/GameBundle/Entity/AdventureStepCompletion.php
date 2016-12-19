<?php

namespace Badger\Bundle\GameBundle\Entity;

use Badger\Component\Game\Model\AdventureStepCompletionInterface;
use Badger\Component\Game\Model\AdventureStepInterface;
use Badger\Component\User\Model\UserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class AdventureStepCompletion implements AdventureStepCompletionInterface
{
    /** @var string */
    protected $id;

    /** @var UserInterface */
    protected $user;

    /** @var AdventureStepInterface */
    protected $step;

    /** @var \DateTime */
    protected $completionDate;

    /** @var bool */
    protected $pending;

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
    public function setId($id)
    {
        $this->id = $id;
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
     * {@inheritdoc}
     */
    public function getAdventureStep()
    {
        return $this->step;
    }

    /**
     * {@inheritdoc}
     */
    public function setAdventureStep(AdventureStepInterface $step)
    {
        $this->step = $step;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompletionDate()
    {
        return $this->completionDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompletionDate(\DateTime $completionDate)
    {
        $this->completionDate = $completionDate;
    }

    /**
     * {@inheritdoc}
     */
    public function isPending()
    {
        return $this->pending;
    }

    /**
     * {@inheritdoc}
     */
    public function setPending($pending)
    {
        $this->pending = $pending;
    }
}
