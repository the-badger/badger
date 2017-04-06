<?php

namespace Badger\Bundle\GameBundle\Unlocker;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\Game\Repository\BadgeCompletionRepositoryInterface;
use Badger\Component\Game\Unlocker\BadgeUnlockerInterface;
use Badger\Component\StorageUtils\Saver\SaverInterface;
use Badger\Component\User\Model\UserInterface;
use Badger\Bundle\GameBundle\Factory\BadgeCompletionFactory;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class BadgeUnlocker implements BadgeUnlockerInterface
{
    /** @var BadgeCompletionFactory */
    private $badgeCompletionFactory;

    /** @var BadgeCompletionRepositoryInterface */
    private $badgeCompletionRepository;

    /** @var SaverInterface */
    private $badgeCompletionSaver;

    /**
     * @param BadgeCompletionFactory             $badgeCompletionFactory
     * @param BadgeCompletionRepositoryInterface $badgeCompletionRepository
     * @param SaverInterface                     $badgeCompletionSaver
     */
    public function __construct(
        BadgeCompletionFactory $badgeCompletionFactory,
        BadgeCompletionRepositoryInterface $badgeCompletionRepository,
        SaverInterface $badgeCompletionSaver
    ) {
        $this->badgeCompletionFactory    = $badgeCompletionFactory;
        $this->badgeCompletionRepository = $badgeCompletionRepository;
        $this->badgeCompletionSaver      = $badgeCompletionSaver;
    }

    /**
     * {@inheritdoc}
     */
    public function unlockBadge(UserInterface $user, BadgeInterface $badge)
    {
        if (!$this->badgeCompletionRepository->userHasBadge($user, $badge)) {
            $unlockedBadge = $this->badgeCompletionFactory->create($user, $badge);
            $this->badgeCompletionSaver->save($unlockedBadge);
        }
    }
}
