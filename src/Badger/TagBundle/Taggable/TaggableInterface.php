<?php

namespace Badger\TagBundle\Taggable;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
interface TaggableInterface
{
    /**
     * @param ArrayCollection $tags
     */
    public function setTags(ArrayCollection $tags);

    /**
     * @return ArrayCollection
     */
    public function getTags();
}
