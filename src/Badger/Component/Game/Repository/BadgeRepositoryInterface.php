<?php

namespace Badger\Component\Game\Repository;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Repository interface for Badge entities.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface BadgeRepositoryInterface extends ObjectRepository
{
    /**
     * Count all Badges in database.
     *
     * @return int
     */
    public function countAll();
}
