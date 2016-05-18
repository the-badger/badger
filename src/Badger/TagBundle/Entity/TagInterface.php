<?php

namespace Badger\TagBundle\Entity;

use Badger\GameBundle\Entity\BadgeInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface TagInterface
{
    /**
     * Get id
     *
     * @return int
     */
    public function getId();

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TagInterface
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set code
     *
     * @param string $code
     *
     * @return TagInterface
     */
    public function setCode($code);

    /**
     * Get code
     *
     * @return string
     */
    public function getCode();

    /**
     * @param bool $isDefault
     *
     * @return TagInterface
     */
    public function setIsDefault($isDefault);

    /**
     * @return bool
     */
    public function isDefault();

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return TagInterface
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return BadgeInterface[]
     */
    public function getBadges();

    /**
     * @param BadgeInterface[] $badges
     */
    public function setBadges(array $badges);
}
