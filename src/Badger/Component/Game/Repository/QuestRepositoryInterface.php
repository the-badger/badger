<?php

namespace Badger\Component\Game\Repository;

use Badger\Component\Tag\Taggable\TaggableInterface;
use Badger\Component\User\Model\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Quest repository interface
 *
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
     * @return array
     */
    public function getAvailableQuestsForUser(TaggableInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return array
     */
    public function getCompletedQuestsForUser(UserInterface $user);

    /**
     * Returns all passed quests since the given date
     *
     * @return ArrayCollection
     */
    public function getPassedQuestsSince();
}
