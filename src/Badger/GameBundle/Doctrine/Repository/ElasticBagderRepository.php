<?php

namespace Badger\UserBundle\Doctrine\Repository;

use Badger\GameBundle\Repository\ElasticBadgeRepositoryInterface;
use Elastica\SearchableInterface;

/**
 * @author    Olivier Soulet <olivier.soulet@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class ElasticBadgerRepository implements ElasticBadgeRepositoryInterface
{
    /** @var SearchableInterface */
    protected $finder;

    /**
     * @param SearchableInterface $finder
     */
    public function __construct(SearchableInterface $finder)
    {
        $this->finder = $finder;
    }

    /**
     * {@inheritdoc}
     */
    public function findBadge($token)
    {
        $query = new \Elastica\Query\Fuzzy();
        $query->setField('title', $token);
        $query->setField('description', $token);

        $finalQuery = new \Elastica\Query($query);
        $finalQuery->setFields(['title', 'description']);
        $finalQuery->setHighlight(
            [
                'pre_tags'  => ['<em style="color: #FF66FF;">'],
                'post_tags' => ['</em>'],
                'fields'    =>
                    [
                        'title' =>
                            [
                                'fragment_size'       => 200,
                                'number_of_fragments' => 1,
                            ],
                        'description' =>
                            [
                                'fragment_size'       => 200,
                                'number_of_fragments' => 1,
                            ],
                    ]
            ]
        );

        $results = $this->finder->search($finalQuery);

        return $results;
    }
}
