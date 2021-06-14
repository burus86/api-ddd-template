<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Security;

use App\Shared\Domain\Model\AbstractEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package App\Core\Domain\Model\Security
 */
class User extends AbstractEntity implements UserInterface
{
    /**
     * @var string
     */
    private $fullname;

    /**
     * @var string
     */
    private $apiToken;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string|null
     */
    private $roles;

    /**
     * @var string The hashed password
     */
    private $password;


    /**
     * User constructor.
     * @param string|null $fullname
     * @param string|null $apiToken
     * @param string|null $username
     * @param string|null $password
     * @param array|null $roles
     */
    public function __construct(?string $fullname = null, ?string $apiToken = null, ?string $username = null, ?string $password = null, ?array $roles = null)
    {
        parent::__construct();
        $this->fullname = $fullname;
        $this->apiToken = $apiToken;
        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles ?? [];
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function __toString(): string
    {
        return $this->getUsername();
    }
}
