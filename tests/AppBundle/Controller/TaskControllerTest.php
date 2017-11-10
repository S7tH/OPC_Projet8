<?php

namespace Tests\AppBundle\Controller;

class TaskControllerTest extends AbstractControllerTest
{
    public function testTaskListpageIsUp()
    {
        //user is authenticated
        $this->logUser();

        /*call the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $this->client->request('GET', '/tasks');

        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();

        //The test with the code status expected
        $this->assertSame(200,$response);

        //To display the html code remove the double slash ahead the following line
        //echo $this->client->getResponse()->getContent();
    }

    public function testTaskListWithRequestIsUp()
    {
        //user is authenticated
        $this->logUser();

        /*call the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $this->client->request('GET', '/tasks?overtasks=1');

        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();

        //The test with the code status expected
        $this->assertSame(200,$response);

        //To display the html code remove the double slash ahead the following line
        //echo $this->client->getResponse()->getContent();
    }

    public function testTaskCreatepageIsUp()
    {
        //user is authenticated
        $this->logUser();

        /*calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $this->client->request('GET', '/tasks/create');
    
        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();
        
        //The test with the code status expected
        $this->assertSame(200,$response);

        //To display the html code remove the double slash ahead the following line
        //echo $this->client->getResponse()->getContent();
    }

    
    public function testTaskCreatepageIsOk()
    {
        //user is authenticated
        $this->logUser();

        /*recover the crawler in calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $crawler = $this->client->request('GET', '/tasks/create');
    
        //recover the form to fill it
        $form = $crawler->selectButton('Ajouter')->form();

        $form['task[title]'] = 'test title';
        $form['task[content]'] = 'test content';
    
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

    public function testTaskEditpageIsUp()
    {
        //user is authenticated as admin
        $this->logAdmin();

        /*calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $this->client->request('GET', '/tasks/4/edit');
    
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

    public function testTaskEditpageIsOk()
    {
        //user is authenticated as admin
        $this->logAdmin();

        /*recover the crawler in calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $crawler = $this->client->request('GET', '/tasks/4/edit');

        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();

        //if task asked doesn't exist
        if($this->client->getResponse()->isNotFound())
        {
            //The test with the code status expected
            $this->assertSame(404,$response);
        }
        else
        {
            //recover the form to fill it
            $form = $crawler->selectButton('Modifier')->form();
            $form['task[title]'] = 'test title edit';
        
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

    public function testTaskTooglepageIsOk()
    {
        //user is authenticated
        $this->logAdmin();

        /*calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $this->client->request('GET', '/tasks/4/toggle');
        
        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();
            
        //if task asked doesn't exist
        if($this->client->getResponse()->isNotFound())
        {
            //The test with the code status expected
            $this->assertSame(404,$response);
        }
        else
        {
            //The test with the code status expected
            $this->assertSame(302,$response);

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

    public function testTaskDeleteAccessDenied()
    {
        //user is authenticated as user. Only the author-creator is be able to delete this own task
        $this->logUser();

        /*calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $this->client->request('GET', '/tasks/7/delete');
        
        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();
            
        if($this->client->getResponse()->isNotFound())
        {
            //The test with the code status expected
            $this->assertSame(404,$response);
        }
        else
        {
            //The test with the code status expected here 403 if user has not the rights
            $this->assertSame(302,$response);

            //to can be able to watch the result
            $crawler = $this->client->followRedirect();
            
            //recover the response with status code
            $response = $this->client->getResponse()->getStatusCode();
            
            //The test with the code status expected
            $this->assertSame(200,$response);
            
            /*The test with the number of time that the element dom should be apear in first parameter
            , the dom element in second parameter*/
            $this->assertSame(1,$crawler->filter('div.alert.alert-danger')->count());
        }
        
        //To display the html code remove the double slash ahead the following line
        echo $this->client->getResponse()->getContent();
    }

    public function testTaskDeleteAnonymousAccessDenied()
    {
        //user is authenticated as user. Only admin is be able to delete an anonymous task
        $this->logUser();

        /*calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover here task 6 has an anymous author*/
        $this->client->request('GET', '/tasks/6/delete');
        
        //recover the response with status code
        $response = $this->client->getResponse()->getStatusCode();
            
        if($this->client->getResponse()->isNotFound())
        {
            //The test with the code status expected
            $this->assertSame(404,$response);
        }
        else
        {
            //The test with the code status expected here 403 if user has not the rights
            $this->assertSame(302,$response);

            //to can be able to watch the result
            $crawler = $this->client->followRedirect();
            
            //recover the response with status code
            $response = $this->client->getResponse()->getStatusCode();
            
            //The test with the code status expected
            $this->assertSame(200,$response);
            
            /*The test with the number of time that the element dom should be apear in first parameter
            , the dom element in second parameter*/
            $this->assertSame(1,$crawler->filter('div.alert.alert-danger')->count());
        }
        
        //To display the html code remove the double slash ahead the following line
        echo $this->client->getResponse()->getContent();
    }

    public function testTaskDeletepageIsOk()
    {
        //user is authenticated
        $this->logAdmin();
      
        /*recover the crawler in calling the request method with 2 parameters
        1/ the http method 2/ the uri what we want to recover*/
        $this->client->request('GET', '/tasks/4/delete');

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
            $this->assertSame(302,$response);

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