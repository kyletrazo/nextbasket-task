<?php

namespace App\Tests\Unit\Domain\Model;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetSetEmail(): void
    {
        $user = new User();
        $email = 'test@example.com';
        
        $user->setEmail($email);
        
        $this->assertSame($email, $user->getEmail());
    }

    public function testGetSetFirstName(): void
    {
        $user = new User();
        $firstName = 'John';
        
        $user->setFirstName($firstName);
        
        $this->assertSame($firstName, $user->getFirstName());
    }

    public function testGetSetLastName(): void
    {
        $user = new User();
        $lastName = 'Doe';
        
        $user->setLastName($lastName);
        
        $this->assertSame($lastName, $user->getLastName());
    }
}
