<?php

namespace Badger\Bundle\GameBundle\Tests\Controller;

use Badger\BadgerTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class BadgeControllerTest extends BadgerTestCase
{
    public function testNewBadgeAction()
    {
        $client = $this->createUser();

        $count = count($this->get('badger.game.repository.badge')->findAll());

        $this->createBadge($client);

        $this->assertCount($count++, $this->get('badger.game.repository.badge')->findAll());
    }

    public function testDeleteAction()
    {
        $client = $this->createUser();

        $count = count($this->get('badger.game.repository.badge')->findAll());

        $badge = $this->get('badger.game.repository.badge')->findOneBy(['title' => 'Master Contributor']);
        $this->deleteBadge($client, $badge->getId());

        $this->assertCount($count -= 1, $this->get('badger.game.repository.badge')->findAll());
    }

    public function testDeleteWhenBadgeHasBeenClaimed()
    {
        $client = $this->createUser();

        $countBadge = count($this->get('badger.game.repository.badge')->findAll());
        $countClaimedBadge = count($this->get('badger.game.repository.badge_completion')->findAll());

        $badge = $this->get('badger.game.repository.badge')->findOneBy(['title' => 'Bug Hunter']);
        $this->deleteBadge($client, $badge->getId());

        $this->assertCount($countBadge -= 1, $this->get('badger.game.repository.badge')->findAll(), 'Badge is removed');
        $this->assertCount($countClaimedBadge -= 1, $this->get('badger.game.repository.badge_completion')->findAll(), 'Claimed badge completion is removed');
    }

    public function testDeleteWhenBadgeHasBeenUnlocked()
    {
        $client = $this->createUser();

        $countBadge = count($this->get('badger.game.repository.badge')->findAll());
        $countUnlockedBadge = count($this->get('badger.game.repository.badge_completion')->findAll());

        $badge = $this->get('badger.game.repository.badge')->findOneBy(['title' => 'Bug Hunter']);
        $this->deleteBadge($client, $badge->getId());

        $this->assertCount($countBadge -= 1, $this->get('badger.game.repository.badge')->findAll(), 'Badge is removed');
        $this->assertCount($countUnlockedBadge -= 1, $this->get('badger.game.repository.badge_completion')->findAll(), 'Badge completion is removed');
    }

    /**
     * @param Client $client
     */
    private function createBadge(Client $client)
    {
        $tag = $this->get('badger.game.repository.tag')->findOneBy(['code' => 'company']);

        $client->request('POST', 'admin/badge/new', [
            'badge' => [
                'title' => 'Part of the team',
                'tags' => [$tag->getId()]
            ]
        ]);
    }

    /**
     * @param Client $client
     * @param string $id
     */
    private function deleteBadge(Client $client, $id)
    {
        $client->request('POST', sprintf('admin/badge/%s/delete', $id), [
            '_method' => 'DELETE',
            'form' => []
        ]);
    }
}
