<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Security\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testRedirectToLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertTrue(
            $client
                ->getResponse()
                ->isRedirect('/login')
        );
    }

    public function testIndex()
    {
        $client = static::createClient();
        $userMock = $this->getMockUser();
        static::$kernel->getContainer()
            ->set(
                'app.user',
                $userMock
            );

        $crawler = $client->request('GET', '/');
        $this->assertFalse(
            $client
                ->getResponse()
                ->isRedirect('/login')
        );

        $this->assertContains(
            $userMock->getDisplayName(),
            $crawler
                ->filter('div.loginname')
                ->text()
        );
    }

    public function testLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertContains(
            'My Connections',
            $crawler
                ->filter('div.page-title > h1')
                ->text()
        );

        $this->assertContains(
            'Login',
            $crawler
                ->filter('div.modal div.modal-inner > h1')
                ->text()
        );

        $link = $crawler
            ->filter('p.modal-content > a.btn')
            ->eq(0)
            ->link();

        $this->assertContains(
            '/auth',
            $link->getUri()
        );
    }

    public function getMockUser()
    {
        $user = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'isLoggedIn',
                    'getDisplayName',
                    'getUid',
                    'getUsername'
                ]
            )
            ->getMock();

        $user->expects($this->any())
            ->method('isLoggedIn')
            ->will($this->returnValue(TRUE));
        $user->expects($this->any())
            ->method('getDisplayName')
            ->will($this->returnValue('TestUser'));
        $user->expects($this->any())
            ->method('getUid')
            ->will($this->returnValue('test'));
        $user->expects($this->any())
            ->method('getUsername')
            ->will($this->returnValue('testuser'));

        return $user;
    }
}
