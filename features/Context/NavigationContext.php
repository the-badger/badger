<?php

namespace Context;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ExpectationException;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;

/**
 * @author    Léo Benoist <leo.benoist@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class NavigationContext implements SnippetAcceptingContext, KernelAwareContext
{
    use KernelDictionary;

    /** @var \Behat\MinkExtension\Context\MinkContext */
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
     * Opens specified page.
     *
     * @param string $route
     *
     * @Given /^(?:|I )am on route "(?P<route>[^"]+)"$/
     * @When /^(?:|I )go to route "(?P<route>[^"]+)"$/
     */
    public function visitRoute($route)
    {
        $this->minkContext->visit($this->getContainer()->get('router')->generate($route));
    }

    /**
     * Opens specified page.
     *
     * @param string $route
     * @param array  $parameters
     *
     * @Given /^(?:|I )am on route "(?P<route>[^"]+)" with:$/
     * @When /^(?:|I )go to route "(?P<route>[^"]+)" with:$/
     */
    public function visitRouteWithParam($route, array $parameters)
    {
        $this->minkContext->visit($this->getContainer()->get('router')->generate($route, $parameters));
    }

    /**
     * @param string $page
     *
     * Checks, that current page PATH is equal to specified.
     *
     * @Then /^(?:|I )should be redirected to "(?P<page>[^"]+)"$/
     */
    public function assertPageAddress($page)
    {
        $this->minkContext->assertPageAddress($page);
    }

    /**
     * Checks, that current page PATH is equal to specified.
     *
     * @param string $route
     *
     * @throws ExpectationException
     *
     * @Then /^(?:|I )should be on route "(?P<route>[^"]+)"$/
     * @Then /^(?:|I )should be redirected to route "(?P<route>[^"]+)"$/
     */
    public function assertPageRoute($route)
    {
        $router     = $this->getContainer()->get('router');
        $urlMatcher = new UrlMatcher($router->getRouteCollection(), $router->getContext());
        $request    = Request::create($this->minkContext->getSession()->getCurrentUrl());
        $match      = $urlMatcher->matchRequest($request);

        if (!is_array($match) || $route != $match['_route']) {
            throw new ExpectationException(
                sprintf(
                    "The URI '%s' does not match the requested route '%s'",
                    $request->getPathInfo(),
                    $route
                ),
                $this->minkContext->getSession()
            );
        }
    }

    /**
     * @param TableNode $table
     *
     * @return array
     *
     * @Transform table:parameter,value
     */
    public function convertTableToKeyValueArray(TableNode $table)
    {
        $returnArray = [];

        array_map(
            function ($line) use (&$returnArray) {
                $returnArray[$line[0]] = $line[1];
            },
            $table->getTable()
        );

        return $returnArray;
    }
}
