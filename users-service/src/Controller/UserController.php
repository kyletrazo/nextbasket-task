<?php

namespace App\Controller;

use App\Application\Command\User\CreateUserCommand;
use App\DTO\CreateUserDTO;
use App\Service\Serializer\DTOSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    private $messageBus;
    private $validator;

    public function __construct(MessageBusInterface $messageBus, ValidatorInterface $validator)
    {
        $this->messageBus = $messageBus;
        $this->validator = $validator;
    }

    #[Route('/users', name: 'user', methods: ['POST'])]
    public function createUser(Request $request, DTOSerializer $serializer): Response
    {
        $userDTO = $serializer->deserialize($request->getContent(), CreateUserDTO::class, 'json');
    
        $errors = $this->validator->validate($userDTO);
        if (count($errors) > 0) {
            $userDTO->setStatus('failed');

            return new Response($serializer->serialize($userDTO, 'json'), Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
        }
    
        $this->handleUserCreation($userDTO);
    
        return new Response($serializer->serialize($userDTO, 'json'), Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
    }
    
    private function handleUserCreation(CreateUserDTO $userDTO): void
    {
        $command = new CreateUserCommand($userDTO->getEmail(), $userDTO->getFirstName(), $userDTO->getLastName());
        $this->messageBus->dispatch($command);
    
        $userDTO->setStatus('created');
    }  
}
