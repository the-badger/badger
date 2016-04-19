<?php

namespace Badger\TagBundle\Repository;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Repository interface for Tag entities.
 *
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface TagRepositoryInterface extends ObjectRepository
{
    /**
     * Find if there is already a tag with isDefault = true
     *
     * @param array $fields
     *
     * @return array
     */
    public function findByUniqueIsDefault(array $fields);
}
