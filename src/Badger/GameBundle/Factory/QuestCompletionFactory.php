<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\QuestCompletion;
use Badger\GameBundle\Entity\QuestInterface;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
