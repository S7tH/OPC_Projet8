<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testChangeRoles()
    {
        $user = new User();
        //The initial role will be this
        $user->setRoles(['ROLE_INIT']);

        //a rolename is sending by a form
        $user->setRolename('ROLE_TEST');
        //check if the Roles has been update with the rolename
        $this->assertSame(['ROLE_TEST'], $user->getRoles());
    }

    public function testNoChangeRoles()
    {
        $user = new User();
        //The initial role will be this
        $user->setRoles(['ROLE_INIT']);

        //the user don't change the initial role in the form user update
        $user->setRolename(null);
        //check if the Role initial has not been change
        $this->assertSame(['ROLE_INIT'], $user->getRoles());
    }
}
