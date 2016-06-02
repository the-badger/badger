<?php

namespace Badger\GameBundle\Entity;

use Badger\UserBundle\Entity\UserInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
