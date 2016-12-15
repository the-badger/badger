<?php

namespace Badger\GameBundle\Entity;

use Badger\UserBundle\Entity\UserInterface;

/**
 * An RefusedHistory is the entity that represents all entities that have been refused for a given user in badger.
 *
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class RefusedHistory implements RefusedHistoryInterface
{
    /** @var string */
    protected $id;

    /** @var UserInterface */
    protected $user;

    /** @var string */
    protected $entityType;

    /** @var string */
    protected $entityId;

    /**
     * {@inheritdoc}
     */
    public function setEntityType($entityType)
    {
        $this->entityType = $entityType;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityType()
    {
        return $this->entityType;
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
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * {@inheritdoc}
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
    }
}
