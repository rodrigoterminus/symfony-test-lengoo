<?php

namespace AppBundle\Util;


use Symfony\Component\OptionsResolver\OptionsResolver;

class Mailer
{
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        ;

        $this->options = $resolver->resolve($options);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'from' => 'contact@lengoo.com'
        ]);

        $resolver
            ->setRequired([
                'mailer',
                'subject',
                'to',
                'body'
            ])
            ->setAllowedTypes('mailer', \Swift_Mailer::class);
    }

    public function send() {
        $message = (new \Swift_Message('We received your application'))
            ->setFrom($this->options['from'])
            ->setTo($this->options['to'])
            ->setBody($this->options['body']);

        $mailer = $this->options['mailer'];
        $mailer->send($message);
    }
}