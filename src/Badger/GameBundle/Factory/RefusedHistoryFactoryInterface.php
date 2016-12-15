<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\RefusedHistoryInterface;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface RefusedHistoryFactoryInterface
{
    /**
     * Create a RefusedHistory instance from a given $user and $entityType.
     *
     * @param UserInterface $user
     * @param string        $entityType
     * @param string        $entityId
     *
     * @return RefusedHistoryInterface
     */
    public function create(UserInterface $user, $entityType, $entityId);
}
