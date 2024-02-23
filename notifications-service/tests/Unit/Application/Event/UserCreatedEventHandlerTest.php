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

        $loggerMock = $this->createMock(LoggerInterface::class);
        
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

        $event = new UserCreatedEvent($email, $firstName, $lastName);

        $handler = new UserCreatedEventHandler($loggerMock);

        $handler($event);
    }
}
