<?php

namespace Badger;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\Container;

/**
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class BadgerTestCase extends WebTestCase
{
    /** @var Container */
    protected $container;

    /**
     * @param string $user
     * @param string $password
     *
     * @return Client
     */
    public function createUser($user = 'admin', $password = 'admin')
    {
        return static::createClient(
            [],
            [
                'PHP_AUTH_USER' => $user,
                'PHP_AUTH_PW'   => $password,
            ]
        );
    }

    public function setUp()
    {
        static::bootKernel([]);

        $this->container = self::$kernel->getContainer();

        $command = $this->get('hautelook_alice.doctrine.command.load_command');
        $command->setApplication(new Application(self::$kernel));
        $commandTester = new CommandTester($command);
        $commandTester->execute([], ['interactive' => false]);
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    protected function get($serviceName)
    {
        return $this->container->get($serviceName);
    }
}
