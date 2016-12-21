<?php

namespace Badger\Bundle\GameBundle\Factory;

use Badger\Bundle\GameBundle\Entity\Adventure;
use Badger\Bundle\GameBundle\Entity\AdventureStep;
use Badger\Component\Game\Factory\SimpleFactoryInterface;

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
