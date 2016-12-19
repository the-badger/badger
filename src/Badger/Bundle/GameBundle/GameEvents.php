<?php

namespace Badger\Bundle\GameBundle;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class GameEvents
{
    /**
     * The Game.user_unlocks_badge event is thrown each time a user unlocked
     * a new badge.
     *
     * The event listener receives a
     * Badger\Bundle\GameBundle\Event\BadgeUnlockEvent
     *
     * @var string
     */
    const USER_UNLOCKS_BADGE = 'game.user_unlocks_badge';
}
