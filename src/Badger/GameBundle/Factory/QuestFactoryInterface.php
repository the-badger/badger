<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Quest;

/**
 * @author Olivier Soulet <olivier.soulet@akeneo.com>
 */
interface QuestFactoryInterface
{
    /**
     * Create a Quest instance.
     *
     * @return Quest
     */
    public function create();
}
