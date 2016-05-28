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
     * {@inheritdoc}
     */
    public function getOpinion()
    {
        if (0 === $this->opinion) {
            return null;
        }
        if ($this->opinion > 0) {
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function setOpinion($opinion)
    {
        if (null === $opinion) {
            $this->opinion = 0;
        }
        else {
            $this->opinion = $opinion ? 1 : -1;
        }

        return $this;
    }
}
