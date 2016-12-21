<?php

namespace Badger\Bundle\GameBundle\Factory;

use Badger\Bundle\GameBundle\Entity\AdventureStepCompletion;
use Badger\Component\Game\Model\AdventureStepInterface;
use Badger\Component\User\Model\UserInterface;

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
