<?php

namespace Badger\GameBundle\Entity;

use Badger\UserBundle\Entity\UserInterface;

/**
 * Badge vote entity
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeVote implements BadgeVoteInterface
{
    /** @var string */
    protected $id;

    /** @var UserInterface */
    protected $user;

    /** @var BadgeProposalInterface */
    protected $badgeProposal;

    /** @var integer */
    protected $opinion;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBadgeProposal()
    {
        return $this->badgeProposal;
    }

    /**
     * {@inheritdoc}
     */
    public function setBadgeProposal(BadgeProposalInterface $badgeProposal)
    {
        $this->badgeProposal = $badgeProposal;

        return $this;
    }

    /**
     * @return bool
     */
    public function getOpinion()
    {
        return $this->opinion > 0;
    }

    /**
     * @param bool $opinion
     *
     * @return BadgeVoteInterface
     */
    public function setOpinion($opinion)
    {
        $this->opinion = $opinion ? 1 : -1;

        return $this;
    }
}
