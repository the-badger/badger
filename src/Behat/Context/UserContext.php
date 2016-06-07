<?php

namespace Behat\Context;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Mink\Driver\CoreDriver;
use Behat\Mink\Driver\ZombieDriver;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;

/**
 * @author    Léo Benoist <leo.benoist@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class UserContext implements SnippetAcceptingContext, KernelAwareContext
{
    use KernelDictionary;

    /** @var MinkContext */
    protected $minkContext;

    /**
     * @BeforeScenario
     *
     * @param BeforeScenarioScope $scope
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->minkContext = $environment->getContext('Behat\MinkExtension\Context\MinkContext');
    }

    /**
     * @Given I am an anonymous user
     */
    public function iAmAnAnonymousUser()
    {
        $this->getDriver()->reset();
    }

    /**
     * @param string $username
     *
     * @Given I am authenticated as :username
     * @Given I am logged as :username
     */
    public function iAmAuthenticatedAs($username)
    {
        $session = $this->getContainer()->get('session');

        $user = $this->getContainer()->get('fos_user.user_manager')->findUserByUsername($username);

        if (!$user) {
            throw new \InvalidArgumentException(sprintf('The user "%s" doesn\'t exist!', $username));
        }

        $providerKey = $this->getContainer()->getParameter('fos_user.firewall_name');

        $token = new OAuthToken($username, $user->getRoles());
        $token->setUser($user);
        $token->setResourceOwnerName('github');
        $session->set('_security_'.$providerKey, serialize($token));
        $session->save();

        if ($this->getDriver() instanceof ZombieDriver) {
            $this->minkContext->visit($this->getContainer()->get('router')->generate('hwi_oauth_connect'));
        }

        $this->minkContext->getSession()->setCookie($session->getName(), $session->getId());
        $this->getContainer()->get('security.token_storage')->setToken($token);
    }

    /**
     * @return CoreDriver
     */
    public function getDriver()
    {
        return $this->minkContext->getSession()->getDriver();
    }
}
