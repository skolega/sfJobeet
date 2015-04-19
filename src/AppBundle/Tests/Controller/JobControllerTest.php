<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/oferty');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/usun/{id}');
    }

    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/dodaj');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/edytuj/{id}');
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/oferta/{id}');
    }

}
