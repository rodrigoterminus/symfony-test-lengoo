<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = (new User())
            ->setUsername('lengoo')
            ->setSalt(md5(uniqid()))
            ->setRoles(['ROLE_ADMIN']);

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'lengoo');

        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}