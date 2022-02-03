<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USERS = [
        [
            'email' => 'admin@portfolio.com',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ],
    ];

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = self::USERS;

        foreach ($users as $index => $userData) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, $userData['password']);

            $user
                ->setEmail($userData['email'])
                ->setPassword($password)
                ->setRoles($userData['roles']);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
