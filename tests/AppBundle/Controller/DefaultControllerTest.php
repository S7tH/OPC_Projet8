<?php

namespace Tests\AppBundle\Controller;

class DefaultControllerTest extends AbstractControllerTest
{
    //test homepage
    public function testHomepageIsUp()
    {
        //user is authenticated
        $this->logUser();

        /*recover the crawler in calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $this->client->request('GET', '/');

        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();

        //The test with the code status expected
        $this->assertSame(200,$response);

        //To display the html code remove the double slash ahead the following line
        //echo $this->client->getResponse()->getContent();
    }
}
