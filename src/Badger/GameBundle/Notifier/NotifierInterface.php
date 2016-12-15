<?php

namespace Badger\GameBundle\Notifier;

/**
 * Simple Notifier interface to notify data somewhere.
 *
 * @author  Adrien Pétremann <adrien.petremann@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface NotifierInterface
{
    /**
     * @param mixed $data
     */
    public function notify($data);
}
