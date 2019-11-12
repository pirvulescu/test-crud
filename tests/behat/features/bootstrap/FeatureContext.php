<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\Assert;

class FeatureContext implements Context
{

    protected $client;

    /**
     * The current resource
     */
    protected $resource;

    /**
     * The request payload
     */
    protected $requestPayload;

    /** @var \GuzzleHttp\Psr7\Response */
    protected $response;

    /**
     * The decoded response object.
     */
    protected $responsePayload;

    /**
     * The current scope within the response payload
     * which conditions are asserted against.
     */
    protected $scope;

    public function __construct()
    {
        $config['base_uri'] = 'http://webserver';
        $this->client = new Client();
    }

    /**
     * @Given /^I make a GET request to "([^"]*)"$/
     * @param string $route
     */
    public function iMakeAGETRequestTo(string $route)
    {
        try {
            $this->response = $this->client->get($this->getUrl($route));
        } catch (ClientException $e) {
            $this->response = $e->getResponse();
        }
    }

    /**
     * @Then /^the response code should be (\d+)$/
     * @param int $expectedResponseCode
     */
    public function theResponseCodeShouldBe(int $expectedResponseCode)
    {
        Assert::assertEquals($expectedResponseCode, $this->response->getStatusCode());
    }

    /**
     * @Given /^I make a POST request to the route "([^"]*)" with the Payload$/
     *
     * @param string $route
     * @param PyStringNode $payload
     */
    public function iMakeAPOSTRequestToTheRouteWithThePayload(string $route, PyStringNode $payload)
    {
        $options['body'] = $payload->getRaw();

        $this->response = $this->client->post($this->getUrl($route), $options);
    }

    /**
     * @Then the response should have attribute :attributeName equal with :attributeValue
     *
     * @param string $attributeName
     * @param string $attributeValue
     */
    public function theResponseShouldHaveAttributeEqualWith($attributeName, $attributeValue)
    {
        $result = json_decode((string)$this->response->getBody(), true);
        Assert::assertEquals($attributeValue, $result[$attributeName]);
    }

    private function getUrl($route)
    {
        return 'http://webserver/' . $route;
    }
}
