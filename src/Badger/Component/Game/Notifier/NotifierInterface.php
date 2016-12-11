<?php

namespace Badger\Component\Game\Notifier;

/**
 * Simple Notifier interface to notify data somewhere.
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface NotifierInterface
{
    /**
     * @param mixed $data
     */
    public function notify($data);
}
