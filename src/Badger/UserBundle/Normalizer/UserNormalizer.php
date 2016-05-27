<?php

namespace Badger\UserBundle\Normalizer;

use Badger\UserBundle\Entity\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * User normalizer
 *
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
            'id' => (int) $user->getId(),
            'username' => (string) $user->getUsername(),
            'profilePicture' => (string) $user->getProfilePicture(),
            'tags' => $this->normalizeTags($user->getTags()),
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
    private function normalizeTags(PersistentCollection $tags)
    {
        $normalizedTags = [];
        foreach ($tags as $tag) {
            $normalizedTags[] = [(string) $tag->getName()];
        }

        return $normalizedTags;
    }
}
