<?php

namespace Ironforge\AchievementBundle\Notifier;

/**
 * Simple Notifier interface to notify data somewhere.
 *
 * @author Adrien Pétremann <petremann.adrien@gmail.com>
 */
interface NotifierInterface
{
    /**
     * @param mixed $data
     */
    public function notify($data);
}
