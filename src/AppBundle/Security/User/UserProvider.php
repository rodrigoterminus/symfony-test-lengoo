<?php

namespace AppBundle\Security\User;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserProvider implements UserProviderInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    public function  __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function loadUserByUsername($username) : UserInterface
    {
        try {
            $repository = $this->em->getRepository(User::class);

            return $repository->findOneByUsername($username);
        } catch (NoResultException $e) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
    }

    public function refreshUser(UserInterface $user) : UserInterface
    {
        if (!User instanceof $user) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) : bool
    {
        return User::class === $class;
    }
}