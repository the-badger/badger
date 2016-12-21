<?php

namespace Badger\Bundle\GameBundle\Factory;

use Badger\Bundle\GameBundle\Entity\QuestCompletion;
use Badger\Component\Game\Model\QuestInterface;
use Badger\Component\User\Model\UserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class QuestCompletionFactory
{
    /**
     * {@inheritdoc}
     */
    public function create(UserInterface $user, QuestInterface $quest)
    {
        $questCompletion = new QuestCompletion();

        $questCompletion->setUser($user);
        $questCompletion->setQuest($quest);
        $questCompletion->setCompletionDate(new \DateTime());
        $questCompletion->setPending(true);

        return $questCompletion;
    }
}
