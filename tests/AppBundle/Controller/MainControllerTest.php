<?php

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class MainControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertRegExp('#/en/$#', $response->headers->get('location'));

        $crawler = $client->followRedirect();
        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('Hangman', trim($crawler->filter('h1')->text()));
    }
}
