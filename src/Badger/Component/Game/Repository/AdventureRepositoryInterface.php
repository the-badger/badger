<?php

namespace Badger\Component\Game\Repository;

use Badger\Component\Game\Taggable\TaggableInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface AdventureRepositoryInterface
{
    /**
     * Return available adventures for the given $user, depending his tags.
     *
     * @param TaggableInterface $user
     *
     * @return array
     */
    public function getAvailableAdventuresForUser(TaggableInterface $user);

    /**
     * Return completed adventures for the given $user.
     *
     * @param TaggableInterface $user
     *
     * @return array
     */
    public function getCompletedAdventuresForUser(TaggableInterface $user);
}
