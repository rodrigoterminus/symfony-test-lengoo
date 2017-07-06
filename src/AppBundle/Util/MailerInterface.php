<?php

namespace AppBundle\Util;

interface MailerInterface
{
    /**
     * Send email using Swift_Mailer
     *
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $body
     * @return boolean
     */
    public function send(string $subject, string $from, string $to, string $body);
}