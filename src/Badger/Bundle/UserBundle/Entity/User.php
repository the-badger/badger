<?php

namespace Badger\Bundle\UserBundle\Entity;

use Badger\Component\Game\Model\TagInterface;
use Badger\Component\Game\Taggable\TaggableInterface;
use Badger\Component\User\Model\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class User extends BaseUser implements UserInterface, TaggableInterface
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $github_id;

    /** @var string */
    protected $google_id;

    /** @var string */
    protected $github_access_token;

    /** @var string */
    protected $google_access_token;

    /** @var string */
    protected $profilePicture;

    /** @var ArrayCollection */
    protected $tags;

    /** @var int */
    protected $nuts;

    /** @var \DateTime */
    protected $date_registered;

    /**
     * {@inheritdoc}
     */
    public function getGithubId()
    {
        return $this->github_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setGithubId($github_id)
    {
        $this->github_id = $github_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getGithubAccessToken()
    {
        return $this->github_access_token;
    }

    /**
     * {@inheritdoc}
     */
    public function setGithubAccessToken($github_access_token)
    {
        $this->github_access_token = $github_access_token;
    }

    /**
     * {@inheritdoc}
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setGoogleId($google_id)
    {
        $this->google_id = $google_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * {@inheritdoc}
     */
    public function setGoogleAccessToken($google_access_token)
    {
        $this->google_access_token = $google_access_token;
    }

    /**
     * {@inheritdoc}
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * {@inheritdoc}
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * {@inheritdoc}
     */
    public function addTag(TagInterface $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTags(ArrayCollection $tags)
    {
        $this->tags = $tags;
    }

    /**
     * {@inheritdoc}
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * {@inheritdoc}
     */
    public function getNuts()
    {
        return $this->nuts;
    }

    /**
     * {@inheritdoc}
     */
    public function setNuts($nuts)
    {
        $this->nuts = $nuts;
    }

    /**
     * {@inheritdoc}
     */
    public function addNuts($nuts)
    {
        $this->nuts += $nuts;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateRegistered()
    {
        return $this->date_registered;
    }

    /**
     * {@inheritdoc}
     */
    public function setDateRegistered($registeredDate)
    {
        $this->date_registered = $registeredDate;
    }
}
