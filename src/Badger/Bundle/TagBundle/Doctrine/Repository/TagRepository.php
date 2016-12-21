<?php

namespace Badger\Bundle\TagBundle\Doctrine\Repository;

use Badger\Bundle\TagBundle\Repository\TagRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * Doctrine implementation of repository for Tag entities.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class TagRepository extends EntityRepository implements TagRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByUniqueIsDefault(array $fields)
    {
        if (false === $fields['isDefault']) {
            return null;
        }

        try {
            return $this
                ->createQueryBuilder('t')
                ->where('t.isDefault = true')
                ->getQuery()
                ->getSingleResult();

        } catch (NoResultException $e) {
            return null;
        }
    }
}
