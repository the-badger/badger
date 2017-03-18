<?php

namespace Badger\Bundle\GameBundle\Security;

use Badger\Component\Game\Model\TagInterface;
use Badger\Component\Game\Taggable\TaggableInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Voter for tagged entities.
 * A tagged entity must implements the TaggableInterface
 *
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class TaggedEntityVoter extends Voter
{
    const VIEW = 'view';

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW])) {
            return false;
        }

        if (!$subject instanceof TaggableInterface) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof TaggableInterface) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($subject, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * Return true if the given $user can view the given $entity.
     * The $entity can be viewed by the $user if they have AT LEAST ONE common tag.
     *
     * @param TaggableInterface $entity
     * @param TaggableInterface $user
     *
     * @return bool
     */
    private function canView(TaggableInterface $entity, TaggableInterface $user)
    {
        $badgeTagIds = $entity->getTags()
            ->map(function(TagInterface $tag) {
                return $tag->getId();
            })
            ->toArray();

        $userTagIds = $user->getTags()
            ->map(function(TagInterface $tag) {
                return $tag->getId();
            })
            ->toArray();

        return count(array_intersect($badgeTagIds, $userTagIds)) > 0;
    }
}
