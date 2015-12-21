<?php

namespace AppBundle\Tests\Connections;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @file
 * Project: orcid
 * File: RepositoryTest.php
 */
class ServiceFactoryTest extends KernelTestCase
{
    private $container;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
    }

    public function testFactory()
    {
        /* @var \AppBundle\Connections\ServiceFactory $factory */
        $factory = $this->container->get('app.service.factory');
        $this->assertInstanceOf(\AppBundle\Connections\ServiceFactory::class, $factory);

        /* @var \AppBundle\Connections\Service $orcid */
        $orcid = $this->container->get('app.service.orcid');
        $this->assertInstanceOf(\AppBundle\Connections\Service::class, $orcid);

    }
}
