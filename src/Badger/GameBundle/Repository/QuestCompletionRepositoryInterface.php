<?php

namespace Badger\GameBundle\Repository;

use Badger\UserBundle\Entity\UserInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Repository interface for QuestCompletion entities.
 *
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface QuestCompletionRepositoryInterface extends ObjectRepository
{
    public function getQuestIdsClaimedByUser(UserInterface $user);
}
