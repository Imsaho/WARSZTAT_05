<?php

namespace ContactBoxBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testNewcontact()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/new');
    }

    public function testEditcontact()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/edit');
    }

    public function testRemovecontact()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/remove');
    }

    public function testShowcontact()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/show');
    }

    public function testShowallcontacts()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/sowAll');
    }

}
