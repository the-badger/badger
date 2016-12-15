<?php

namespace Badger\TagBundle\Taggable;

use Badger\TagBundle\Entity\TagInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author  Adrien Pétremann <adrien.petremann@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface TaggableInterface
{
    /**
     * @param TagInterface $tag
     *
     * @return TaggableInterface
     */
    public function addTag(TagInterface $tag);

    /**
     * @param ArrayCollection $tags
     */
    public function setTags(ArrayCollection $tags);

    /**
     * @return ArrayCollection
     */
    public function getTags();
}
