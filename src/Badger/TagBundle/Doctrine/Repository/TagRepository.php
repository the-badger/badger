<?php

namespace Badger\TagBundle\Doctrine\Repository;

use Badger\TagBundle\Repository\TagRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * Doctrine implementation of repository for Tag entities.
 *
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
