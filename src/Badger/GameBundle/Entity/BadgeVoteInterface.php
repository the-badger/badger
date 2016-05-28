<?php

namespace Badger\GameBundle\Entity;

use Badger\UserBundle\Entity\UserInterface;

/**
 * Badge vote entity interface
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface BadgeVoteInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @param UserInterface $user
     *
     * @return BadgeVoteInterface
     */
    public function setUser(UserInterface $user);

    /**
     * @return BadgeProposalInterface
     */
    public function getBadgeProposal();

    /**
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return BadgeVoteInterface
     */
    public function setBadgeProposal(BadgeProposalInterface $badgeProposal);

    /**
     * @return bool|null
     */
    public function getOpinion();

    /**
     * @param bool|null $opinion
     *
     * @return BadgeVoteInterface
     */
    public function setOpinion($opinion);
}
