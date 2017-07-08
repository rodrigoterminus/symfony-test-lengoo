<?php
/**
 * Created by PhpStorm.
 * User: rodrigo
 * Date: 08/07/17
 * Time: 02:37
 */

namespace Tests\AppBundle\Security\User;

use AppBundle\Entity\User;
use AppBundle\Security\User\UserProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserProviderTest extends KernelTestCase
{
    /**
     * @var UserProvider
     */
    private $userProvider;

    public function setUp(){
        self::bootKernel();

        $this->userProvider = static::$kernel->getContainer()
            ->get('app.user_provider');
    }

    public function testLoadUserByUsernameSuccessful()
    {
        $user = $this->userProvider->loadUserByUsername('lengoo');

        $this->assertInstanceOf(User::class, $user);
    }

    public function testLoadUserByUsernameUnsuccessful()
    {
        $this->expectException(UsernameNotFoundException::class);

        $this->userProvider->loadUserByUsername('foo.bar');
    }
}
