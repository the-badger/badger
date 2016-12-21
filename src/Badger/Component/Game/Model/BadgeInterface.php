<?php

namespace Badger\Component\Game\Model;

use Badger\Component\Tag\Taggable\TaggableInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Badge entity interface
 *
 * @author  Pierre Allard <pierre.allard@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface BadgeInterface extends TaggableInterface
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
     * @return $this
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getImagePath();

    /**
     * @param string $imagePath
     *
     * @return $this
     */
    public function setImagePath($imagePath);

    /**
     * @return string|null
     */
    public function getImageAbsolutePath();

    /**
     * @return string|null
     */
    public function getImageWebPath();

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null);

    /**
     * @return UploadedFile
     */
    public function getFile();

    /**
     * Uploads a file
     */
    public function upload();
}
