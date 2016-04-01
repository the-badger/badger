<?php

namespace Badger\TagBundle\Entity;

use Badger\GameBundle\Entity\Badge;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
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
     * @return Badge[]
     */
    public function getBadges();

    /**
     * @param Badge[] $badges
     */
    public function setBadges(array $badges);
}
