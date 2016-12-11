<?php

namespace Badger\GameBundle\Factory;

use Badger\Component\Game\Factory\SimpleFactoryInterface;
use Badger\GameBundle\Entity\Adventure;
use Badger\GameBundle\Entity\AdventureStep;

/**
 * @author  Marie Bochu <marie.bochu@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class AdventureFactory implements SimpleFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $adventure = new Adventure();
        $adventure->addStep(new AdventureStep());

        return $adventure;
    }
}