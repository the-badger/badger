<?php

namespace Badger\UserBundle\Repository;

/**
 * @author    Olivier Soulet <olivier.soulet@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface ElasticUserRepositoryInterface
{
    /**
     * @param string $token
     *
     * @return array
     */
    public function findUser($token);
}
