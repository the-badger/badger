<?php

namespace Badger\Bundle\GameBundle\Tests\Unlocker;

use Badger\BadgerTestCase;

/**
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class BadgeUnlockerTest extends BadgerTestCase
{
    public function testUnlockBadge()
    {
        $user = $this->get('badger.user.repository.user')->findOneBy(['username' => 'user_1']);
        $badge = $this->get('badger.game.repository.badge')->findOneBy(['title' => 'Bug Hunter']);

        $count = count($this->get('badger.game.repository.unlocked_badge')->getUnlockedBadgeIdsByUser($user));

        $this->get('badger.game.unlocker.badge')->unlockBadge($user, $badge);

        $this->assertCount($count += 1, $this->get('badger.game.repository.unlocked_badge')->getUnlockedBadgeIdsByUser($user));
    }

    public function testUnlockBadgeWhenUserHasAlreadyTheBadge()
    {
        $user = $this->get('badger.user.repository.user')->findOneBy(['username' => 'user_1']);
        $badge = $this->get('badger.game.repository.badge')->findOneBy(['title' => 'ASS Disruptor']);

        $count = count($this->get('badger.game.repository.unlocked_badge')->getUnlockedBadgeIdsByUser($user));

        $this->get('badger.game.unlocker.badge')->unlockBadge($user, $badge);

        $this->assertCount($count, $this->get('badger.game.repository.unlocked_badge')->getUnlockedBadgeIdsByUser($user));
    }

    public function testUnlockBadgeFromClaim()
    {
        $claimedBadges = $this->get('badger.game.repository.claimed_badge')->findAll();

        $count = count($claimedBadges);
        $user = $this->get('badger.user.repository.user')->findOneBy(['username' => 'user_2']);
        $countBadges = count($this->get('badger.game.repository.unlocked_badge')->getUnlockedBadgeIdsByUser($user));

        $this->get('badger.game.unlocker.badge')->unlockBadgeFromClaim(current($claimedBadges));

        $this->assertCount($count -= 1, $this->get('badger.game.repository.claimed_badge')->findAll(), 'Claimed badge has been removed');
        $this->assertCount($countBadges += 1, $this->get('badger.game.repository.unlocked_badge')->getUnlockedBadgeIdsByUser($user), 'Badge has been added');
    }
}
