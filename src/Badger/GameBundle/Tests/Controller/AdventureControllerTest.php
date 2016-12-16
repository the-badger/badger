<?php

namespace Badger\GameBundle\Tests\Controller;

use Badger\BadgerTestCase;
use Badger\GameBundle\Repository\AdventureRepositoryInterface;
use Badger\GameBundle\Repository\AdventureStepCompletionRepositoryInterface;
use Badger\GameBundle\Repository\BadgeRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Validator\Validator;

/**
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AdventureControllerTest extends BadgerTestCase
{
    /** @var AdventureRepositoryInterface */
    private $adventureRepository;

    /** @var ObjectRepository */
    private $adventureStepRepository;

    /** @var AdventureStepCompletionRepositoryInterface */
    private $adventureComplRepo;

    /** @var BadgeRepositoryInterface */
    private $badgeRepository;

    public function setUp()
    {
        parent::setUp();

        $this->adventureRepository = $this->get('badger.game.repository.adventure');
        $this->adventureStepRepository = $this->get('badger.game.repository.adventure_step');
        $this->adventureComplRepo = $this->get('badger.game.repository.adventure_step_completion');
        $this->badgeRepository = $this->get('badger.game.repository.badge');
    }

    public function testCreateAdventureAction()
    {
        $client = $this->createUser();

        $adventureCount = count($this->adventureRepository->findAll());
        $adventureStepsCount = count($this->adventureStepRepository->findAll());

        $client->request('POST', 'admin/adventure/form', [
            'adventure' => [
                'title' => 'title',
                'description' => 'Summer Session',
                'rewardPoint' => 0,
                'isStepLinked' => false,
                'badge' => null,
                'steps' => [
                    [
                        'title' => 2013,
                        'position' => 1,
                        'description' => 'Summer Session 2013',
                        'rewardPoint' => 0
                    ],
                    [
                        'title' => 2014,
                        'position' => 2,
                        'description' => 'Summer Session 2014',
                        'rewardPoint' => 0
                    ]
                ]
            ]
        ]);

        $this->assertCount($adventureCount+=1, $this->adventureRepository->findAll());
        $this->assertCount($adventureStepsCount+=2, $this->adventureStepRepository->findAll());
    }

    public function testContraintsFormAction()
    {
        $client = $this->createUser();

        $client->enableProfiler();
        $adventureCount = count($this->adventureRepository->findAll());

        $client->request('POST', 'admin/adventure/form', [
            'adventure' => [
                'title' => 'ASS',
            ]
        ]);

        $profile = $client->getProfile();

        $form = $profile->getCollector('form')->getData();
        $this->assertEquals(2, $form['nb_errors']);
        $this->assertEquals('This value is already used.', $form['forms']['adventure']['children']['title']['errors'][0]['message']);
        $this->assertCount($adventureCount, $this->adventureRepository->findAll());
    }

    public function testDeleteAction()
    {
        $client = $this->createUser();

        $adventureCount = count($this->adventureRepository->findAll());
        $adventureStepCount = count($this->adventureStepRepository->findAll());
        $adventureComplRepoCount = count($this->adventureComplRepo->findAll());
        $badgeCount = count($this->badgeRepository->findAll());

        $adventure = $this->adventureRepository->findOneBy(['title' => 'Community']);
        $client->request('POST', 'admin/adventure/delete/' . $adventure->getId(), [
            '_method' => 'DELETE',
            'form'    => []
        ]);

        $this->assertCount($adventureCount-=1, $this->adventureRepository->findAll(), 'Adventure is removed');
        $this->assertCount($adventureStepCount-=2, $this->adventureStepRepository->findAll(), 'Steps of adventure are removed');
        $this->assertCount($adventureComplRepoCount-=1, $this->adventureComplRepo->findAll(), 'Completions steps of adventure are removed');
        $this->assertCount($badgeCount, $this->badgeRepository->findAll(), 'Badge are not removed when an adventure is removed');
    }

    public function testUpdateAnAdventureToDeleteAStep()
    {
        $client = $this->createUser();

        $adventureCount = count($this->adventureRepository->findAll());
        $adventureStepsCount = count($this->adventureStepRepository->findAll());
        $adventureCompletionCount = count($this->adventureComplRepo->findAll());

        $adventure = $this->adventureRepository->findOneBy(['title' => 'Community']);
        $badge = $this->badgeRepository->findOneBy(['title' => 'Master Contributor']);

        $client->request('POST', sprintf('admin/adventure/form/%s', $adventure->getId()), [
            'adventure' => [
                'title' => 'Community',
                'description' => '',
                'rewardPoint' => 10,
                'isStepLinked' => true,
                'badge' => $badge->getId(),
                'steps' => [
                    [
                        'title' => 'Core Contributor',
                        'position' => 1,
                        'description' => 'You merged your first Pull Request on our PIM Community Edition!',
                        'rewardPoint' => 0
                    ]
                ]
            ]
        ]);

        $this->assertCount($adventureCount, $this->adventureRepository->findAll(), 'No adventure added or removed');
        $this->assertCount($adventureStepsCount-=1, $this->adventureStepRepository->findAll(), 'Step deleted');
        $this->assertCount($adventureCompletionCount-=1, $this->adventureComplRepo->findAll(), 'Adventure Completion linked to deleted step is removed');
    }

    public function testDeleteWhenStepsAreLinkedToBadges()
    {
        $client = $this->createUser();

        $adventureCount = count($this->adventureRepository->findAll());
        $adventureStepCount = count($this->adventureStepRepository->findAll());
        $adventureComplRepoCount = count($this->adventureComplRepo->findAll());
        $badgeCount = count($this->badgeRepository->findAll());

        $adventure = $this->adventureRepository->findOneBy(['title' => 'ASS']);
        $client->request('POST', 'admin/adventure/delete/' . $adventure->getId(), [
            '_method' => 'DELETE',
            'form'    => []
        ]);

        $this->assertCount($adventureCount-=1, $this->adventureRepository->findAll(), 'Adventure is removed');
        $this->assertCount($adventureStepCount-=4, $this->adventureStepRepository->findAll(), 'Steps of adventure are removed');
        $this->assertCount($adventureComplRepoCount-=2, $this->adventureComplRepo->findAll(), 'Completions steps of adventure are removed');
        $this->assertCount($badgeCount, $this->badgeRepository->findAll(), 'Badge are not removed when an adventure is removed');
    }
}
