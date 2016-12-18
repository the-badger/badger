<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\AdventureStepCompletion;
use Badger\GameBundle\Entity\AdventureStepInterface;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class AdventureStepCompletionFactory
{
    /**
     * {@inheritdoc}
     */
    public function create(UserInterface $user, AdventureStepInterface $step)
    {
        $stepCompletion = new AdventureStepCompletion();

        $stepCompletion->setUser($user);
        $stepCompletion->setAdventureStep($step);
        $stepCompletion->setCompletionDate(new \DateTime());
        $stepCompletion->setPending(true);

        return $stepCompletion;
    }
}
