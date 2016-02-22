<?php

namespace Ironforge\AchievementBundle\Notifier;

/**
 * @author Adrien Pétremann <petremann.adrien@gmail.com>
 */
interface NotifierInterface
{
    /**
     * @param mixed $data
     */
    public function notify($data);
}
