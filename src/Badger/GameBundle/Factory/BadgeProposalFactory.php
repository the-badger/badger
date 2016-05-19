<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\BadgeProposal;

/**
 * BadgeProposal creation
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeProposalFactory implements BadgeProposalFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new BadgeProposal();
    }
}
