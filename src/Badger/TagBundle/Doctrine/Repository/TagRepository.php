<?php

namespace Badger\TagBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Badger\TagBundle\Repository\TagRepositoryInterface;

/**
 * Doctrine implementation of repository for Tag entities.
 *
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class TagRepository extends EntityRepository implements TagRepositoryInterface
{

}
