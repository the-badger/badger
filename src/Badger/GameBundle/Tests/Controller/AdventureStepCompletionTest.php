<?php

namespace Badger\GameBundle\Tests\Controller;

use Badger\BadgerTestCase;

/**
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AdventureStepCompletionTest extends BadgerTestCase
{
    public function testRejectAction()
    {
        $client = $this->createUser();

        $adventureStepCompletionRepo = $this->get('badger.game.repository.adventure_step_completion');
        $count = count($adventureStepCompletionRepo->findAll());

        $adventureStepCompletion = $adventureStepCompletionRepo->findOneBy(['pending' => 1])->getId();
        $client->request('GET', sprintf('admin/claimed-adventure-step/%s/reject', $adventureStepCompletion));

        $this->assertCount($count-=1, $adventureStepCompletionRepo->findAll(), 'Adventure step has been rejected and deleted');
    }

    public function testAcceptAction()
    {
        $adventureStepCompletionRepo = $this->get('badger.game.repository.adventure_step_completion');
        $adventureStepCompletions = $adventureStepCompletionRepo->findBy(['pending' => 1]);

        $client = $this->createUser();
        $countPending = count($adventureStepCompletions);
        $countAccepted = count($adventureStepCompletionRepo->findBy(['pending' => 0]));
        $client->request('GET', sprintf('admin/claimed-adventure-step/%s/accept', current($adventureStepCompletions)->getId()));

        $this->assertCount($countPending-=1, $adventureStepCompletionRepo->findBy(['pending' => 1]), 'Adventure step has been accepted');
        $this->assertCount($countAccepted+=1, $adventureStepCompletionRepo->findBy(['pending' => 0]), 'Adventure step has been accepted');
    }
}
