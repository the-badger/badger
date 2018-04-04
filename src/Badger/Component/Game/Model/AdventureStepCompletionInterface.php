<?php

namespace Badger\Component\Game\Model;

use Badger\Component\User\Model\UserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface AdventureStepCompletionInterface
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
     * @return AdventureStepInterface
     */
    public function getAdventureStep();

    /**
     * @param AdventureStepInterface $step
     */
    public function setAdventureStep(AdventureStepInterface $step);

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
