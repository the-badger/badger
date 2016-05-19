<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\BadgeProposalInterface;

/**
 * Interface for BadgeProposal creation
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface BadgeProposalFactoryInterface
{
    /**
     * Create a BadgeInterface instance.
     *
     * @return BadgeProposalInterface
     */
    public function create();
}
