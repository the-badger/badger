<?php

namespace Badger\Bundle\GameBundle\Factory;

use Badger\Bundle\GameBundle\Entity\Quest;
use Badger\Component\Game\Factory\SimpleFactoryInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Quest Factory
 *
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class QuestFactory implements SimpleFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $quest = new Quest();
        $quest->setTags(new ArrayCollection());

        return $quest;
    }
}
