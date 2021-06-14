<?php

declare(strict_types=1);

namespace App\Tests\Core\Infrastructure\DataFixtures;

use App\Core\Domain\Model\Security\User;
use App\Core\Infrastructure\DataFixtures\UserFixtures;
use DateTimeInterface;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserFixturesTest extends KernelTestCase
{
    const TOTAL_IMPORTED = 2;
    const FIRST_USER_FULLNAME = 'Juan Jesús Gómez Noya';
    const FIRST_USER_USERNAME = 'juanjesus.gomeznoya';
    const LAST_USER_FULLNAME = 'Administrator';

    use FixturesTrait;

    public function testLoad()
    {
        $fixtures = $this->loadFixtures([UserFixtures::class])->getReferenceRepository();
        $users = $fixtures->getManager()->getRepository(User::class)->findAll();
        $this->assertCount(self::TOTAL_IMPORTED, $users);
        foreach ($users as $user) {
            $this->assertInstanceOf(User::class, $user);
        }

        /** @var User $firstUser */
        $firstUser = $users[0];
        $this->assertGreaterThan(0, count($users));
        $this->assertEquals(self::FIRST_USER_FULLNAME, $firstUser->getFullname());
        $this->assertEquals(self::FIRST_USER_USERNAME, $firstUser->getUsername());
        $this->assertInstanceOf(DateTimeInterface::class, $firstUser->getCreatedAt());
        $this->assertNotNull($firstUser->getPassword());

        /** @var User $lastUser */
        $lastUser = end($users);
        $this->assertGreaterThan(1, $lastUser->getId());
        $this->assertEquals(self::LAST_USER_FULLNAME, $lastUser->getFullname());
    }
}
