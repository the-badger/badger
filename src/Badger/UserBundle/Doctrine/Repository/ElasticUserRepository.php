<?php

namespace Badger\UserBundle\Doctrine\Repository;

use Badger\UserBundle\Repository\ElasticUserRepositoryInterface;
use Elastica\SearchableInterface;

/**
 * User repository for data contained in the Elasticsearch database.
 *
 * @author    Olivier Soulet <olivier.soulet@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class ElasticUserRepository implements ElasticUserRepositoryInterface
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
    public function findUser($token)
    {
        $query = new \Elastica\Query\Fuzzy();
        $query->setField('username', $token);

        $finalQuery = new \Elastica\Query($query);
        $finalQuery->setFields(['username', 'profilePicture']);
        $finalQuery->setHighlight(
            [
                'pre_tags'  => ['<em style="color: #FF66FF;">'],
                'post_tags' => ['</em>'],
                'fields'    =>
                    [
                        'username' =>
                            [
                                'fragment_size'       => 200,
                                'number_of_fragments' => 1,
                            ],
                    ]
            ]
        );

        $users = $this->finder->search($finalQuery);

        $results = [];
        foreach ($users as $user) {
            $results[] = [
                'username' => $user->getData()['username'][0],
                'profilePicture' => $user->getData()['profilePicture'][0],
                'highlights' => $user->getHighlights()['username'][0],
            ];
        }

        return $results;
    }
}
