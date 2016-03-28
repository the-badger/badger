<?php

namespace Ironforge\TagBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Ironforge\TagBundle\Repository\TagRepositoryInterface;

/**
 * Doctrine implementation of repository for Tag entities.
 *
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class TagRepository extends EntityRepository implements TagRepositoryInterface
{

}
