<?php
/**
 * Created by PhpStorm.
 * User: rodrigo
 * Date: 08/07/17
 * Time: 04:27
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DomCrawler\Crawler;

class SecurityControllerTest extends WebTestCase
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    /**
     * @var Symfony\Component\DomCrawler\Form
     */
    private $form;

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();

        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/login');

        $this->form = $this->crawler->filter('button[type=submit]')->form();
    }

    public function testAttemptToLogInWithRightCredentials()
    {
        $this->form['_username']->setValue('lengoo');
        $this->form['_password']->setValue('lengoo');
        $this->client->submit($this->form);
        $this->client->followRedirect();

        $this->assertNotEquals(
            'login',
            $this->client->getRequest()->get('_route')
        );
    }

    public function testAttemptToLogInWithWrongUsername()
    {
        $this->form['_username']->setValue('foo');
        $this->form['_password']->setValue('bar');
        $this->client->submit($this->form);
        $this->client->followRedirect();

        $this->assertEquals(
            'login',
            $this->client->getRequest()->get('_route')
        );
    }

    public function testAttemptToLogInWithWrongPassword()
    {
        $this->form['_username']->setValue('lengoo');
        $this->form['_password']->setValue('bar');
        $this->client->submit($this->form);
        $this->client->followRedirect();

        $this->assertEquals(
            'login',
            $this->client->getRequest()->get('_route')
        );
    }
}
