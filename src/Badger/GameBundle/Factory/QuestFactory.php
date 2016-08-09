<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Quest;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Quest Factory
 *
 * @author    Olivier Soulet <olivier.soulet@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class QuestFactory implements SimpleFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $quest = new Quest();
        $quest->setTags(new ArrayCollection());

        return $quest;
    }
}
