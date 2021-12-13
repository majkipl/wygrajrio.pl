<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        // USER WITH ADMIN ROLE
        $user = new User();
        $user->setEmail('test@test.com');
        $user->setRoles(['ROLE_ADMIN']);

        $hash = $this->passwordHasher->hashPassword($user, 'asd123');
        $user->setPassword($hash);

        $manager->persist($user);
        $manager->flush();
    }
}
