<?php

namespace Badger\GameBundle\Repository;

use Badger\TagBundle\Taggable\TaggableInterface;

/**
 * @author  Adrien Pétremann <adrien.petremann@akeneo.com>
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
