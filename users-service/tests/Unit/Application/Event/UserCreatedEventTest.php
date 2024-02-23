<?php

namespace App\Tests\Unit\Application\Event;

use App\Application\Event\UserCreatedEvent as UserEvent;
use PHPUnit\Framework\TestCase;

class UserCreatedEventTest extends TestCase
{
    public function testEventProperties(): void
    {
        $email = 'user@example.com';
        $firstName = 'John';
        $lastName = 'Doe';

        $event = new UserEvent($email, $firstName, $lastName);

        // Assert that each property is correctly set and returned
        $this->assertSame($email, $event->getEmail(), 'Email should match the constructor argument.');
        $this->assertSame($firstName, $event->getFirstName(), 'First name should match the constructor argument.');
        $this->assertSame($lastName, $event->getlastName(), 'Last name should match the constructor argument.');
    }
}
