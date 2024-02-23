<?php

namespace App\Tests\Application\EventHandler;

use App\Application\Event\UserCreatedEvent;
use App\Application\EventHandler\UserCreatedEventHandler;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class UserCreatedEventHandlerTest extends TestCase
{
    public function testInvokeLogsInfoCorrectly(): void
    {
        $email = 'user@example.com';
        $firstName = 'John';
        $lastName = 'Doe';

        // Create a mock of the LoggerInterface.
        $loggerMock = $this->createMock(LoggerInterface::class);
        
        // Expect the 'info' method to be called once with the specific message and context.
        $loggerMock->expects($this->once())
                   ->method('info')
                   ->with(
                       $this->equalTo('UserCreatedEvent received'),
                       $this->equalTo([
                           'email' => $email,
                           'firstName' => $firstName,
                           'lastName' => $lastName,
                       ])
                   );

        // Create an instance of UserCreatedEvent with test data.
        $event = new UserCreatedEvent($email, $firstName, $lastName);
        
        // Initialize the handler with the mocked logger.
        $handler = new UserCreatedEventHandler($loggerMock);
        
        // Invoke the handler with the event.
        $handler($event);
    }
}
