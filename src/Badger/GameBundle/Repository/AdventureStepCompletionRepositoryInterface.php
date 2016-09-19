<?php

namespace Badger\GameBundle\Repository;

use Badger\GameBundle\Entity\AdventureInterface;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface AdventureStepCompletionRepositoryInterface
{
    /**
     * Return a collection of completed adventures steps for the given $user,
     * grouped by adventure.
     *
     * @param UserInterface      $user
     * @param AdventureInterface $adventure
     *
     * @return array
     */
    public function userAdventureCompletedSteps(UserInterface $user, AdventureInterface $adventure);

    /**
     * Return a collection of completed adventures steps for the given $user,
     * grouped by adventure.
     *
     * @param UserInterface      $user
     * @param AdventureInterface $adventure
     *
     * @return array
     */
    public function userAdventureClaimedSteps(UserInterface $user, AdventureInterface $adventure);

    /**
     * Return informations about number of completed steps for the given $user
     * per adventures.
     *
     * @param UserInterface $user
     *
     * @return array
     */
    public function userCompletedSteps(UserInterface $user);
}
