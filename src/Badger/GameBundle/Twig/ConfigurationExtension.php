<?php

namespace Badger\GameBundle\Twig;

use Badger\GameBundle\Doctrine\Repository\ConfigurationRepository;

/**
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
