<?php

namespace AppBundle\Tests\Connections;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @file
 * Project: orcid
 * File: RepositoryTest.php
 */
class UserTest extends KernelTestCase
{
    /**
     * @var \AppBundle\Security\User
     */
    private $user;
    private $container;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();

        /* @var \AppBundle\Security\User $user */
        $user = $this->container->get('app.user');

        $user->set('eduPPN', 'phpunit');
        $user->set('nameId', 'phpunit');
        $user->set('displayName', 'phpunit');

        $this->user = $user;

    }

    public function testLogin()
    {
        $this->user->set('eduPPN', null);
        $this->assertFalse($this->user->isLoggedIn());

        $this->user->set('eduPPN', 'phpunit');
        $this->assertTrue($this->user->isLoggedIn());

        $this->assertEquals('phpunit', $this->user->getDisplayName());

    }

    public function testUid()
    {
        $this->assertEquals(
            hash('sha512', 'phpunit'),
            $this->user->getUid()
        );
    }

    public function testDisplayName()
    {
        $this->assertEquals('phpunit', $this->user->getDisplayName());
    }

    public function testUsername()
    {
        $this->assertEquals('phpunit', $this->user->getUsername());
    }
}
