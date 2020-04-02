<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testGetRequest()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->filter('textarea'));
        $this->assertCount(1, $crawler->filter('button'));
        $this->assertCount(1, $crawler->filter('table'));
        $this->assertCount(1, $crawler->filter('.title'));
    }

    public function testForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('form[submit]')->form();

        $form['form[userInput]'] = '10';
        $crawler = $client->submit($form);

        //$this->assertGreaterThan(0, $crawler->filter('td')->count());
        $this->assertCount(2, $crawler->filter('td'));
    }
}
