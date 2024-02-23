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
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $entityManager->expects($this->once())
                      ->method('persist')
                      ->with($this->isInstanceOf(User::class));
        $entityManager->expects($this->once())
                      ->method('flush');

        $command = new CreateUserCommand('test@example.com', 'John', 'Doe');

        $handler = new CreateUserCommandHandler($entityManager);

        $handler($command);
    }
}
