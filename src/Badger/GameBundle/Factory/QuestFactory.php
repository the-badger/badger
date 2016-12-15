<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Quest;
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
