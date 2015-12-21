<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SamlControllerTest extends WebTestCase
{
    public function testMetaData()
    {
        $client = static::createClient();
        $client->request('GET', '/authentication/metadata');

        $this->assertEquals(
            'application/xml',
            $client
                ->getResponse()
                ->headers
                ->get('Content-Type')
        );
    }
}
