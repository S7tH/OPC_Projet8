<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


abstract class AbstractControllerTest extends WebTestCase
{
    protected $client;

    //tests init
    protected function setUp()
    {
        //allow to create the http client
        $this->client = static::createClient();
    }

    protected function logIn($role)
    {
        $session = $this->client->getContainer()->get('session');
        
        // the firewall context defaults to the firewall name
        $firewallContext = 'main';
        
        $token = new UsernamePasswordToken('user', null, $firewallContext, array($role));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    protected function logUser()
    {
        $this->logIn('ROLE_USER');
    }

    protected function logAdmin()
    {
        $this->logIn('ROLE_ADMIN');
    }

    //Deliver the memory once the tests are completed
    protected function tearDown()
    {
        $this->client = null;
    }
}
