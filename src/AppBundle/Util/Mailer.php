<?php

namespace AppBundle\Util;

class Mailer implements MailerInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * Mailer constructor.
     *
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send email using Swift_Mailer
     *
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $body
     *
     * @return boolean
     */
    public function send(string $subject, string $from, string $to, string $body) :bool
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/html');

        return $this->mailer->send($message);
    }
}