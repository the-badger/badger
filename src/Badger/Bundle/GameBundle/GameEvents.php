<?php

namespace Badger\Bundle\GameBundle;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class GameEvents
{
    /**
     * The game.user_unlocked_badge event is thrown each time a user unlocked
     * a new badge.
     *
     * The event listener receives a
     * Badger\Bundle\GameBundle\Event\BadgeUnlockEvent
     *
     * @var string
     */
    const USER_UNLOCKED_BADGE = 'game.user_unlocked_badge';

    /**
     * The game.badge_has_been_rejected event is thrown each time a user badge is rejected
     * a new badge.
     *
     * The event listener receives a
     * Badger\Bundle\GameBundle\Event\BadgeUnlockEvent
     *
     * @var string
     */
    const BADGE_HAS_BEEN_REJECTED = 'game.user_badge_has_been_rejected';

    /**
     * The game.badge_has_been_accepted event is thrown each time a user badge is accepted
     * a new badge.
     *
     * The event listener receives a
     * Badger\Bundle\GameBundle\Event\BadgeUnlockEvent
     *
     * @var string
     */
    const BADGE_HAS_BEEN_REMOVED = 'game.user_badge_has_been_removed';

    /**
     * The game.badge_has_been_claimed event is thrown each time a user has claimed
     * a new badge.
     *
     * The event listener receives a
     * Badger\Bundle\GameBundle\Event\BadgeUnlockEvent
     *
     * @var string
     */
    const BADGE_HAS_BEEN_CLAIMED = 'game.user_badge_has_been_claimed';
}
