<?php

namespace Badger\Component\Game\Repository;

use Badger\Component\Game\Model\TagInterface;

/**
 * Repository interface for tag searchable entities.
 *
 * @author Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
