<?php

namespace Badger\Bundle\GameBundle\Entity;

use Badger\Component\Game\Model\BadgeInterface;
use Badger\Component\Tag\Model\TagInterface;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Badge entity.
 *
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class Badge implements BadgeInterface, JsonSerializable
{
    /** @var string */
    protected $file;

    /** @var string */
    protected $id;

    /** @var string */
    protected $title;

    /** @var string */
    protected $description;

    /** @var string */
    protected $imagePath;

    /** @var ArrayCollection */
    protected $tags;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * {@inheritdoc}
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * {@inheritdoc}
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * {@inheritdoc}
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->imagePath = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
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
     * Returns the absolute path of the image, null if no image
     *
     * @return null|string
     */
    public function getImageAbsolutePath()
    {
        return null === $this->imagePath
            ? null
            : $this->getUploadRootDir() . '/' . $this->imagePath;
    }

    /**
     * Returns the path of the image for the web, null if no image
     *
     * @return null|string
     */
    public function getImageWebPath()
    {
        return null === $this->imagePath
            ? null
            : '/' . $this->getUploadDir() . '/' . $this->imagePath;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'imageWebPath' => $this->getImageWebPath(),
        ];
    }

    /**
     * Returns the absolute directory path where uploaded documents should be saved
     *
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../../web/' . $this->getUploadDir();
    }

    /**
     * Returns the path where upload files.
     *
     * Get rid of the __DIR__ so it doesn't screw up when displaying uploaded doc/image in the view.
     *
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads/game';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}
