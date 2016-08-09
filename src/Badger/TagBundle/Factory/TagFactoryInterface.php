<?php

namespace Badger\TagBundle\Factory;

use Badger\TagBundle\Entity\Tag;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface TagFactoryInterface
{
    /**
     * Create a Tag instance.
     *
     * @return Tag
     */
    public function create();
}
