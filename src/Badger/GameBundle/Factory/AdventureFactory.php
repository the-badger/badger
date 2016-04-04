<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Adventure;
use Badger\GameBundle\Entity\Step;

/**
 * @author Marie Bochu <marie.bochu@akeneo.com>
 */
class AdventureFactory implements BadgeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $adventure = new Adventure();
        $adventure->addStep(new Step());

        return $adventure;
    }
}
