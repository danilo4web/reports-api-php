<?php

namespace App\Entity;

class UserEntity
{
    public function __construct(
        private string $name,
        private string $email,
        private ?string $password
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return UserEntity
     */
    public function setName(string $name): UserEntity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserEntity
     */
    public function setEmail(string $email): UserEntity
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return UserEntity
     */
    public function setPassword(string $password): UserEntity
    {
        $this->password = $password;
        return $this;
    }

    public static function fromArray(array $user): self
    {
        return new self($user['name'], $user['email'], $user['password'] ?? null);
    }
}
