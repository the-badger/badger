<?php

namespace Badger\GameBundle\Entity;

use Badger\UserBundle\Entity\UserInterface;

/**
 * RefusedHistory to keep stats on refused entity in badger.
 *
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface RefusedHistoryInterface
{
    /**
     * Set the type of the refused entity.
     *
     * @param string $entityType
     */
    public function setEntityType($entityType);

    /**
     * Get the type of the refused entity.
     *
     * @return string
     */
    public function getEntityType();

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @param $user
     */
    public function setUser($user);

    /**
     * @return string
     */
    public function getEntityId();

    /**
     * @param string $entityId
     */
    public function setEntityId($entityId);
}
