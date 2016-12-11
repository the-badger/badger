<?php

namespace Badger\Component\Game\Repository;

use Badger\Component\Game\Model\AdventureInterface;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
