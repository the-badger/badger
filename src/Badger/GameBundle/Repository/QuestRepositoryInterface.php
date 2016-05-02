<?php

namespace Badger\GameBundle\Repository;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Repository interface for Quest entities.
 *
 * @author    Olivier Soulet <olivier.soulet@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
