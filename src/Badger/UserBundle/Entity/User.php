<?php

namespace Badger\UserBundle\Entity;

use Badger\TagBundle\Entity\TagInterface;
use Badger\TagBundle\Taggable\TaggableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser implements TaggableInterface
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

    /**
     * @return string
     */
    public function getGithubId()
    {
        return $this->github_id;
    }

    /**
     * @param string $github_id
     */
    public function setGithubId($github_id)
    {
        $this->github_id = $github_id;
    }

    /**
     * @return string
     */
    public function getGithubAccessToken()
    {
        return $this->github_access_token;
    }

    /**
     * @param string $github_access_token
     */
    public function setGithubAccessToken($github_access_token)
    {
        $this->github_access_token = $github_access_token;
    }

    /**
     * @return string
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * @param string $google_id
     */
    public function setGoogleId($google_id)
    {
        $this->google_id = $google_id;
    }

    /**
     * @return string
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * @param string $google_access_token
     */
    public function setGoogleAccessToken($google_access_token)
    {
        $this->google_access_token = $google_access_token;
    }

    /**
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param string $profilePicture
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
}
