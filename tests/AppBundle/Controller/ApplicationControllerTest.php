<?php
/**
 * Created by PhpStorm.
 * User: rodrigo
 * Date: 08/07/17
 * Time: 00:12
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationControllerTest extends WebTestCase
{
    /**
     * @var
     */
    private $container;

    /**
     * @var FileUpload
     */
    private $file;

    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();

        $this->file = new UploadedFile(
            self::$kernel->getRootDir() .'/../README.md',
            'README.md',
            'text',
            '548'
        );

        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/');
    }

    public function testApplicationPageLoads()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testApplicationFormSubmitsSuccessful()
    {
        $form = $this->fillForm([
            'form' => $this->crawler->filter('button[type=submit]')->form(),
            'email' => 'me@rodrigoterminus.com',
            'file' => $this->file
        ]);

        $crawler = $this->client->submit($form);

        $this->assertEquals(
            0,
            $crawler->filter('div.mdl-chip')->count()
        );
    }

    public function testApplicationFormInvalidEmail()
    {
        $form = $this->fillForm([
            'form' => $this->crawler->filter('button[type=submit]')->form(),
            'email' => 'foo@bar.com',
            'file' => $this->file
        ]);

        $crawler = $this->client->submit($form);

        $this->assertEquals(
            1,
            $crawler->filter('span.mdl-chip')->count()
        );
    }

    /**
     * @param array $options
     * @return object
     */
    private function fillForm(array $options = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(array(
            'form' => null,
            'name' => 'Lengoo',
            'email' => null,
            'file' => null,
            'notes' => null,
        ));
        $resolver->setRequired(['form', 'file']);
        $resolver->setAllowedTypes('form', 'Symfony\Component\DomCrawler\Form');
        $options = $resolver->resolve($options);

        $options['form']['appbundle_application[name]']->setValue($options['name']);
        $options['form']['appbundle_application[email]']->setValue($options['email']);
        $options['form']['appbundle_application[file]']->upload($options['file']);
        $options['form']['appbundle_application[notes]']->setValue($options['notes']);

        return $options['form'];
    }
}
