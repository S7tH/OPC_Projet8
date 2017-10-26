<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Controller\UserController;

class UserControllerTest extends AbstractControllerTest
{
    public function testUserListpageIsUp()
    {
        /*call the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $this->client->request('GET', '/users');

        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();

        //The test with the code status expected
        $this->assertSame(200,$response);

        //To display the html code remove the double slash ahead the following line
        //echo $this->client->getResponse()->getContent();
    }

    public function testUserCreatepageIsUp()
    {
        /*calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $this->client->request('GET', '/users/create');
    
        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();
        
        //The test with the code status expected
        $this->assertSame(200,$response);

        //To display the html code remove the double slash ahead the following line
        //echo $this->client->getResponse()->getContent();
    }

    
    public function testUserCreatepageIsOk()
    {
        /*recover the crawler in calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $crawler = $this->client->request('GET', '/users/create');
    
        //recover the form to fill it
        $form = $crawler->selectButton('Ajouter')->form();
        
        $form['user[username]'] = 'user'.rand();
        $form['user[password][first]'] = 'passtest';
        $form['user[password][second]'] = 'passtest';
        $form['user[email]'] = 'user'.rand().'@test.com';
        
        //Submit the form
        $this->client->submit($form);
    
        //to can be able to watch the result
        $crawler = $this->client->followRedirect();
        
        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();
        
        //The test with the code status expected
        $this->assertSame(200,$response);

        /*The test with the number of time that the element dom should be apear in first parameter
        , the dom element in second parameter*/
        $this->assertSame(1,$crawler->filter('div.alert.alert-success')->count());
    
    
        //To display the html code remove the double slash ahead the following line
        //echo $this->client->getResponse()->getContent();
    }

    public function testUserEditpageIsUp()
    {
        //user is authenticated as admin
        $this->logAdmin();

        /*calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $this->client->request('GET', '/users/5/edit');
    
        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();
        
        if($this->client->getResponse()->isNotFound())
        {
            //The test with the code status expected
            $this->assertSame(404,$response);
        }
        else
        {
            //The test with the code status expected
            $this->assertSame(200,$response);
        }
        
        //To display the html code remove the double slash ahead the following line
        //echo $this->client->getResponse()->getContent();
    }

    public function testUserEditpageIsOk()
    {
        //user is authenticated as admin
        $this->logAdmin();

        /*recover the crawler in calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $crawler = $this->client->request('GET', '/users/7/edit');
        
        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();
        
        //if user asked doesn't exist
        if($this->client->getResponse()->isNotFound())
        {
            //The test with the code status expected
            $this->assertSame(404,$response);
        }
        else
        {
            //recover the form to fill it
            $form = $crawler->selectButton('Modifier')->form();
        
            $form['user_edit[password][first]'] = 'passtest';
            $form['user_edit[password][second]'] = 'passtest';
        
            //Submit the form
            $this->client->submit($form);
    
            //to can be able to watch the result
            $crawler = $this->client->followRedirect();
        
            //recover the response with status code
            $response = $this->client->getResponse()->getStatusCode();

            //The test with the code status expected
            $this->assertSame(200,$response);

            /*The test with the number of time that the element dom should be apear in first parameter
            , the dom element in second parameter*/
            $this->assertSame(1,$crawler->filter('div.alert.alert-success')->count());
    
            //To display the html code remove the double slash ahead the following line
            //echo $this->client->getResponse()->getContent();
        }
    }
}