<?php

namespace Badger\TagBundle\Security;

use Badger\TagBundle\Entity\TagInterface;
use Badger\TagBundle\Taggable\TaggableInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Voter for Tag entities.
 * Is able to tell if a User can view a given Tag.
 *
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class TagVoter extends Voter
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

        if (!$subject instanceof TagInterface) {
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

        $tag = $subject;

        switch($attribute) {
            case self::VIEW:
                return $this->canView($tag, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * Return true if the given $user can view the given $tag.
     * The $entity can be viewed by the $user if the user is linked to that $tag.
     *
     * @param TagInterface      $tag
     * @param TaggableInterface $user
     *
     * @return bool
     */
    private function canView(TagInterface $tag, TaggableInterface $user)
    {
        return in_array($tag, $user->getTags()->toArray());
    }
}
