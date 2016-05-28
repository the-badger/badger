<?php

namespace Badger\UserBundle\Entity;

use Badger\TagBundle\Entity\TagInterface;
use Badger\TagBundle\Taggable\TaggableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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

    /** @var ArrayCollection */
    protected $badgeVotes;

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
    public function getBadgetVotes()
    {
        return $this->badgeVotes;
    }
}
