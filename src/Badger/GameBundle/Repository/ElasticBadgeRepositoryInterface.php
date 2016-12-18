<?php

namespace Badger\GameBundle\Repository;

/**
 * @author    Olivier Soulet <olivier.soulet@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface ElasticBadgeRepositoryInterface
{
    /**
     * @param string $token
     *
     * @return array
     */
    public function findBadge($token);
}
