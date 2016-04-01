<?php

namespace Badger\TagBundle\Taggable;

use Doctrine\Common\Collections\ArrayCollection;
use Ironforge\TagBundle\Entity\TagInterface;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
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
