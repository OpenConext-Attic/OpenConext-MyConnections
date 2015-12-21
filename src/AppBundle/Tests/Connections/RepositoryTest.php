<?php

namespace AppBundle\Tests\Connections;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @file
 * Project: orcid
 * File: RepositoryTest.php
 */
class RepositoryTest extends KernelTestCase
{
    private $container;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
    }

    public function testRepository()
    {
        /* @var \AppBundle\Connections\Service $orcid */
        $orcid = $this->container->get('app.service.orcid');
        $this->assertInstanceOf(\AppBundle\Connections\Service::class, $orcid);

        /* @var \AppBundle\Connections\Repository $repository */
        $repository = $this->container->get('app.service.repository');
        $this->assertInstanceOf(\AppBundle\Connections\Repository::class, $repository);

        $this->assertTrue($repository->hasConnection('orcid'));

        $repository->removeConnection('orcid');
        $this->assertFalse($repository->hasConnection('orcid'));

        $this->assertTrue(is_array($repository->getAvailableConnections()));
        $this->assertTrue(empty($repository->getAvailableConnections()));

        $repository->addConnection($orcid);
        $this->assertTrue(is_array($repository->getAvailableConnections()));
        $this->assertFalse(empty($repository->getAvailableConnections()));
        $this->assertTrue($repository->hasConnection('orcid'));
    }
}
