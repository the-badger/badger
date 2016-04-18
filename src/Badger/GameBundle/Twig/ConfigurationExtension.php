<?php

namespace Badger\GameBundle\Twig;

use Badger\GameBundle\Doctrine\Repository\ConfigurationRepository;

/**
 * @author Marie Bochu <marie.bochu@akeneo.com>
 */
class ConfigurationExtension extends \Twig_Extension
{
    /** @var ConfigurationRepository */
    private $repository;

    /**
     * @param ConfigurationRepository $repository
     */
    public function __construct(ConfigurationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('configuration', [$this, 'configuration']),
        );
    }

    /**
     * @param $code
     *
     * @return string|null
     */
    public function configuration($code)
    {
        $configuration = $this->repository->findOneBy(['code' => $code]);

        if (null === $configuration) {
            return null;
        }

        return $configuration->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'configuration';
    }
}
