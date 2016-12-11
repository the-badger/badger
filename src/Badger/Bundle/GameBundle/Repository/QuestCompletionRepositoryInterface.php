<?php

namespace Badger\GameBundle\Repository;

use Badger\UserBundle\Entity\UserInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Repository interface for QuestCompletion entities.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface QuestCompletionRepositoryInterface extends ObjectRepository
{
    public function getQuestIdsClaimedByUser(UserInterface $user);
}
