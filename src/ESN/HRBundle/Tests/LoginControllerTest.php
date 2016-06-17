<?php

namespace ESN\HRBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    /**
     * Test if the galaxy login button is on the login page
     */
    public function testGalaxyLoginButton()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertGreaterThan(
            0,
            $crawler->filter('button')->eq(0)->count()
        );
    }
}