<?php

namespace Badger\GameBundle;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class GameEvents
{
    /**
     * The Game.user_unlocks_badge event is thrown each time a user unlocked
     * a new badge.
     *
     * The event listener receives an
     * Badger\GameBundle\Event\BadgeUnlockEvent
     *
     * @var string
     */
    const USER_UNLOCKS_BADGE = 'game.user_unlocks_badge';
}
