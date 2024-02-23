<?php

namespace App\Tests\Application\Event;

use App\Application\Event\UserCreatedEvent;
use PHPUnit\Framework\TestCase;

class UserCreatedEventTest extends TestCase
{
    public function testEventInitializationAndGetterMethods(): void
    {
        $email = 'john.doe@example.com';
        $firstName = 'John';
        $lastName = 'Doe';

        $event = new UserCreatedEvent($email, $firstName, $lastName);

        // Assert that the getters return the correct values provided during initialization
        $this->assertEquals($email, $event->getEmail(), 'Email should match the constructor argument.');
        $this->assertEquals($firstName, $event->getFirstName(), 'First name should match the constructor argument.');
        $this->assertEquals($lastName, $event->getlastName(), 'Last name should match the constructor argument.');
    }
}
