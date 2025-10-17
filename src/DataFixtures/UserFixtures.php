<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public $hasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this->hasher=$userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $super_admin = new User();
        $super_admin->setEmail('superadmin@free.fr');
        $super_admin->setPassword($this->hasher->hashPassword($super_admin, 'superadmin'));
        $super_admin->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($super_admin);

        $admin = new User();
        $admin->setEmail('admin@free.fr');
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $user = new User();
        $user->setEmail('user@free.fr');
        $user->setPassword($this->hasher->hashPassword($user, 'user'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();
    }
}
