<?php

namespace Badger\GameBundle\Entity;

use Badger\UserBundle\Entity\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Badge proposal entity interface
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface BadgeProposalInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     *
     * @return BadgeProposalInterface
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     *
     * @return BadgeProposalInterface
     */
    public function setDescription($description);

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @param UserInterface $user
     *
     * @return BadgeProposalInterface
     */
    public function setUser(UserInterface $user);

    /**
     * @return ArrayCollection
     */
    public function getBadgeVotes();
}
