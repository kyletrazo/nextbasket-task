<?php

namespace App\Tests\Unit\Application\Command;

use App\Application\Command\User\CreateUserCommand;
use App\Application\Command\UserHandler\CreateUserCommandHandler;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\ORMException;

class CreateUserCommandHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        // Create a mock of the EntityManagerInterface
        $entityManager = $this->createMock(EntityManagerInterface::class);

        // Expect the 'persist' and 'flush' methods to be called once each
        $entityManager->expects($this->once())
                      ->method('persist')
                      ->with($this->isInstanceOf(User::class));
        $entityManager->expects($this->once())
                      ->method('flush');

        // Create an instance of the CreateUserCommand with test data
        $command = new CreateUserCommand('test@example.com', 'John', 'Doe');

        // Create an instance of the CreateUserCommandHandler with the mocked EntityManager
        $handler = new CreateUserCommandHandler($entityManager);

        // Invoke the handler with the command
        $handler($command);
    }
}
