<?php

namespace AppBundle\Util;

use Mockery as m;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var \Mockery
     */
    private $mailerMock;

    public function setUp ()
    {
        $this->mailerMock = m::mock(\Swift_Mailer::class);
        $this->mailer = new Mailer($this->mailerMock);
    }

    public function testIfMailerImplementsMailerInterface ()
    {
        $this->assertInstanceOf(MailerInterface::class, $this->mailer);
    }

    public function testIfSendIsSuccessful ()
    {
        $this->mailerMock->shouldReceive('send')->once()->andReturn(true);

        $result = $this->mailer->send(
            'Subject',
            'from@email.com',
            'to@email.com',
            '<html></html>'
        );

        $this->assertTrue($result);
    }
}
