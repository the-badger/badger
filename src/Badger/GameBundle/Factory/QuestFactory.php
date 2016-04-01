<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Quest;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Olivier Soulet <olivier.soulet@akeneo.com>
 */
class QuestFactory implements QuestFactoryInterface
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
