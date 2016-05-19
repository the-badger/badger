<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Badger\GameBundle\Repository\BadgeProposalRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Doctrine implementation of repository for BadgeProposal entities.
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeProposalRepository extends EntityRepository implements BadgeProposalRepositoryInterface
{
}
