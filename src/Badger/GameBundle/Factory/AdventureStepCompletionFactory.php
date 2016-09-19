<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\AdventureStepCompletion;
use Badger\GameBundle\Entity\AdventureStepInterface;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
