<?php

namespace Badger\UserBundle\Entity;

use FOS\UserBundle\Model\UserInterface as BaseUserInterface;
use FOS\UserBundle\Model\GroupableInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface UserInterface extends BaseUserInterface, GroupableInterface
{
    /**
     * @return string
     */
    public function getGithubId();

    /**
     * @param string $github_id
     */
    public function setGithubId($github_id);

    /**
     * @return string
     */
    public function getGithubAccessToken();

    /**
     * @param string $github_access_token
     */
    public function setGithubAccessToken($github_access_token);

    /**
     * @return string
     */
    public function getGoogleId();

    /**
     * @param string $google_id
     */
    public function setGoogleId($google_id);

    /**
     * @return string
     */
    public function getGoogleAccessToken();

    /**
     * @param string $google_access_token
     */
    public function setGoogleAccessToken($google_access_token);

    /**
     * @return string
     */
    public function getProfilePicture();

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture($profilePicture);
}
