<?php

namespace Badger\GameBundle\Repository;

use Badger\TagBundle\Taggable\TaggableInterface;
use Badger\UserBundle\Entity\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Quest repository interface
 *
 * @author    Olivier Soulet <olivier.soulet@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface QuestRepositoryInterface extends ObjectRepository
{
    /**
     * Returns all active quests
     *
     * @return ArrayCollection
     */
    public function getActiveQuests();

    /**
     * Returns all quests ordered by $field in the given $order
     *
     * @param string $field
     * @param string $order
     *
     * @return array
     */
    public function getQuestsOrdered($field, $order = 'DESC');

    /**
     * @param TaggableInterface $user
     *
     * @return ArrayCollection
     */
    public function getAvailableQuestsForUser(TaggableInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return ArrayCollection
     */
    public function getCompletedQuestsForUser(UserInterface $user);

    /**
     * Returns all passed quests since the given date
     *
     * @return ArrayCollection
     */
    public function getPassedQuestsSince();
}
