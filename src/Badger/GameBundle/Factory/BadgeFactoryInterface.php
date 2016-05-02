<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Badge;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface BadgeFactoryInterface
{
    /**
     * Create a Badge instance.
     *
     * @return Badge
     */
    public function create();
}
