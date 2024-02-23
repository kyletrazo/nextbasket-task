<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserDTO 
{
    private string $status = '';

    #[Assert\NotBlank(message: "Email is required.")]
    private string $email;

    #[Assert\NotBlank(message: "First name is required.")]
    private string $firstName;

    #[Assert\NotBlank(message: "Last name is required.")]
    private string $lastName;

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): string
    {
        return $this->status = $status;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
}