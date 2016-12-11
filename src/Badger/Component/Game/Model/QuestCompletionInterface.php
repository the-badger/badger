<?php

namespace Badger\Component\Game\Model;

use Badger\UserBundle\Entity\UserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface QuestCompletionInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $id
     */
    public function setId($id);

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @param UserInterface $user
     */
    public function setUser($user);

    /**
     * @return QuestInterface
     */
    public function getQuest();

    /**
     * @param QuestInterface $quest
     */
    public function setQuest($quest);

    /**
     * @return \DateTime
     */
    public function getCompletionDate();

    /**
     * @param \DateTime $completionDate
     */
    public function setCompletionDate(\DateTime $completionDate);

    /**
     * @return bool
     */
    public function isPending();

    /**
     * @param bool $pending
     */
    public function setPending($pending);
}
