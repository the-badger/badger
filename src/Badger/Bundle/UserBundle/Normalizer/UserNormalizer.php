<?php

namespace Badger\UserBundle\Normalizer;

use Badger\Component\User\Model\UserInterface;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * User normalizer
 *
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class UserNormalizer implements NormalizerInterface
{
    /** @var array */
    protected $supportedFormats = ['json'];

    /**
     * {@inheritdoc}
     */
    public function normalize($user, $format = null, array $context = [])
    {
        return [
            'id'             => (int) $user->getId(),
            'username'       => (string) $user->getUsername(),
            'profilePicture' => (string) $user->getProfilePicture(),
            'tags'           => $this->normalizeTags($user->getTags()),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof UserInterface && in_array($format, $this->supportedFormats);
    }

    /**
     * @param array $tags
     *
     * @return array
     */
    private function normalizeTags(array $tags)
    {
        $normalizedTags = [];
        foreach ($tags as $tag) {
            $normalizedTags[] = (string) $tag->getName();
        }

        return $normalizedTags;
    }
}
