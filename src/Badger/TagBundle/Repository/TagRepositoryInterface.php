<?php

namespace Badger\TagBundle\Repository;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Repository interface for Tag entities.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
