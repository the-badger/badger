<?php

namespace Badger\Component\User\Model;

use FOS\UserBundle\Model\GroupableInterface;
use FOS\UserBundle\Model\UserInterface as BaseUserInterface;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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

    /**
     * @return int
     */
    public function getNuts();

    /**
     * @param int $nuts
     */
    public function setNuts($nuts);

    /**
     * @param int $nuts
     */
    public function addNuts($nuts);

    /**
     * @return \DateTime
     */
    public function getDateRegistered();

    /**
     * @param $registeredDate
     */
    public function setDateRegistered($registeredDate);
}
