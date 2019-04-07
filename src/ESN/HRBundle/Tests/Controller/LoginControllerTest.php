<?php

namespace ESN\HRBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class LoginControllerTest extends WebTestCase
{
    public function testGalaxyLoginButton()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/login');

        $this->assertGreaterThan(
            0,
            $crawler->filter('button')->eq(0)->count()
        );
    }
}
