<?php

namespace Badger\GameBundle\Notifier;

/**
 * Simple Notifier interface to notify data somewhere.
 *
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface NotifierInterface
{
    /**
     * @param mixed $data
     */
    public function notify($data);
}
