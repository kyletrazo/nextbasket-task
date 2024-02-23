<?php

namespace App\Application\Command\UserHandler;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Application\Command\User\CreateUserCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserCommandHandler
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(CreateUserCommand $command)
    {
        $user = new User();
        $user->setEmail($command->getEmail());
        $user->setFirstName($command->getFirstName());
        $user->setLastName($command->getLastName());

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}