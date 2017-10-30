<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    private $user;

    //tests init 
    public function setUp()
    {
        //allow to create the http client
        $this->user = new User();

        //The initial role will be this
        $this->user->setRoles(['ROLE_INIT']);
    }

    public function testChangeRoles()
    {
        //a rolename is sending by a form
        $this->user->setRolename('ROLE_TEST');
        //check if the Roles has been update with the rolename
        $this->assertSame(['ROLE_TEST'], $this->user->getRoles());
    }

    public function testNoChangeRoles()
    {
        //the user don't change the initial role in the form user update
        $this->user->setRolename(null);
        //check if the Role initial has not been change
        $this->assertSame(['ROLE_INIT'], $this->user->getRoles());
    }

    //Deliver the memory once the tests are completed
    public function tearDown()
    {
        $this->user = null;
    }
}
