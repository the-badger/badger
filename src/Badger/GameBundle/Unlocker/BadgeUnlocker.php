<?php

namespace Badger\GameBundle\Unlocker;

use Badger\GameBundle\Entity\BadgeInterface;
use Badger\GameBundle\Entity\ClaimedBadgeInterface;
use Badger\GameBundle\Factory\UnlockedBadgeFactoryInterface;
use Badger\GameBundle\Repository\UnlockedBadgeRepositoryInterface;
use Badger\StorageUtilsBundle\Remover\RemoverInterface;
use Badger\StorageUtilsBundle\Saver\SaverInterface;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeUnlocker implements BadgeUnlockerInterface
{
    /** @var UnlockedBadgeFactoryInterface */
    private $unlockedBadgeFactory;

    /** @var UnlockedBadgeRepositoryInterface */
    private $unlockedBadgeRepository;

    /** @var SaverInterface */
    private $unlockedBadgeSaver;

    /** @var RemoverInterface */
    private $claimedBadgeRemover;

    /**
     * @param UnlockedBadgeFactoryInterface    $unlockedBadgeFactory
     * @param UnlockedBadgeRepositoryInterface $unlockedBadgeRepository
     * @param SaverInterface                   $unlockedBadgeSaver
     * @param RemoverInterface                 $claimedBadgeRemover
     */
    public function __construct(
        UnlockedBadgeFactoryInterface $unlockedBadgeFactory,
        UnlockedBadgeRepositoryInterface $unlockedBadgeRepository,
        SaverInterface $unlockedBadgeSaver,
        RemoverInterface $claimedBadgeRemover
    ) {
        $this->unlockedBadgeFactory = $unlockedBadgeFactory;
        $this->unlockedBadgeRepository = $unlockedBadgeRepository;
        $this->unlockedBadgeSaver = $unlockedBadgeSaver;
        $this->claimedBadgeRemover = $claimedBadgeRemover;
    }

    /**
     * {@inheritdoc}
     */
    public function unlockBadge(UserInterface $user, BadgeInterface $badge)
    {
        if (!$this->unlockedBadgeRepository->userHasBadge($user, $badge)) {
            $unlockedBadge = $this->unlockedBadgeFactory->create($user, $badge);
            $this->unlockedBadgeSaver->save($unlockedBadge);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function unlockBadgeFromClaim(ClaimedBadgeInterface $claimedBadge)
    {
        $badge = $claimedBadge->getBadge();
        $user = $claimedBadge->getUser();

        $this->unlockBadge($user, $badge);

        $this->claimedBadgeRemover->remove($claimedBadge);
    }
}
