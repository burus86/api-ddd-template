<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\DataFixtures;

use App\Core\Domain\Model\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$fullname, $apiToken, $username, $password, $roles]) {
            $user = new User($fullname, $apiToken, $username, $password, $roles);
            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            ['Juan Jesús Gómez Noya', 'cU70Sbr0qKrUQHE0tw60XQVMwBP8hJrdRMY61xhX', 'juanjesus.gomeznoya', 'root.2021', ['ROLE_SUPER_ADMIN']],
            ['Administrator', 'WZzRhP2UdIeEDZCAtO2V4uFtRzFrKx3MMfq5iEsX', 'admin', 'admin.2021', ['ROLE_ADMIN']],
        ];
    }
}
