<?php

namespace Badger\GameBundle\Repository;

use Badger\TagBundle\Entity\TagInterface;

/**
 * Repository interface for tag searchable entities.
 *
 * @author Olivier Soulet <olivier.soulet@akeneo.com>
 */
interface TagSearchableRepositoryInterface
{
    /**
     * Return all entities filtered by Tags
     *
     * @param TagInterface[] $tags
     *
     * @return mixed
     */
    public function findByTags(array $tags);
}
