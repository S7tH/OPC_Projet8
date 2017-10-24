<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private $client;

    //tests init
    public function setUp()
    {
        //allow to create the http client
        $this->client = static::createClient();
    }

    public function testHomepageIsUp()
    {
        /*call the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $this->client->request('GET', '/');

        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();

        /*The test with the code status expected
        here 302 for redirect to login page if user is not authentificated*/
        $this->assertSame(302,$response);

        //Display our html code
        echo $this->client->getResponse()->getContent();
    }

    //Deliver the memory once the tests are completed
    public function tearDown()
    {
        $this->client = null;
    }
}
