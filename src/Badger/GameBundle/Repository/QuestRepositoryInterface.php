<?php

namespace Badger\GameBundle\Repository;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Repository interface for Quest entities.
 *
 * @author Olivier Soulet <olivier.soulet@akeneo.com>
 */
interface QuestRepositoryInterface extends ObjectRepository
{
    /**
     * Count all Quest in database.
     *
     * @return int
     */
    public function countAll();
}
