<?php

namespace Badger\Component\User\Repository;

/**
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
