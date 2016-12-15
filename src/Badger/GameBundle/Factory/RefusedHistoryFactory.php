<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\RefusedHistory;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author  Olivier Souler <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class RefusedHistoryFactory implements RefusedHistoryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(UserInterface $user, $entityType, $entityId)
    {
        $refusedHistory = new RefusedHistory();
        $refusedHistory->setUser($user);
        $refusedHistory->setEntityType($entityType);
        $refusedHistory->setEntityId($entityId);

        return $refusedHistory;
    }
}
