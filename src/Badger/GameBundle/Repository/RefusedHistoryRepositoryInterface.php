<?php

namespace Badger\GameBundle\Repository;

use Badger\UserBundle\Entity\UserInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Repository interface for RefusedHistory entities.
 *
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface RefusedHistoryRepositoryInterface extends ObjectRepository
{
    /**
     * Get refused entities for a given user.
     *
     * @param UserInterface $user
     * @param string        $entityType
     * @param string        $entityId
     *
     * @return array
     */
    public function getRefusedEntitiesByUser(UserInterface $user, $entityType, $entityId);

    /**
     * Get number of refused entities for a given user.
     *
     * @param UserInterface $user
     * @param string        $entityType
     * @param string        $entityId
     *
     * @return array
     */
    public function getNumberOfRefusedEntitiesByUser(UserInterface $user, $entityType, $entityId);
}
