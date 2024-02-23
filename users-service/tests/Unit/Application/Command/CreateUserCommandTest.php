<?php

namespace App\Tests\Unit\Application\Command;

use App\Application\Command\User\CreateUserCommand;
use PHPUnit\Framework\TestCase;

class CreateUserCommandTest extends TestCase
{
    public function testCreateUserCommandProperties(): void
    {
        $email = 'user@example.com';
        $firstName = 'John';
        $lastName = 'Doe';

        $command = new CreateUserCommand($email, $firstName, $lastName);

        $this->assertSame($email, $command->getEmail(), 'Email should be returned correctly.');
        $this->assertSame($firstName, $command->getFirstName(), 'First name should be returned correctly.');
        $this->assertSame($lastName, $command->getLastName(), 'Last name should be returned correctly.');
    }
}
