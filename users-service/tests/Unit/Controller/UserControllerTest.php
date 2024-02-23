<?php

namespace App\Tests\Unit\Controller;

use App\Controller\UserController;
use App\DTO\CreateUserDTO;
use App\Service\Serializer\DTOSerializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserControllerTest extends TestCase
{
    public function testCreateUserWithValidationErrors(): void
    {
        $messageBusMock = $this->createMock(MessageBusInterface::class);
        $validatorMock = $this->createMock(ValidatorInterface::class);
        $serializerMock = $this->createMock(DTOSerializer::class);

        $userDTO = new CreateUserDTO();
        $userDTO->setEmail('invalid-email');
        $userDTO->setFirstName('');
        $userDTO->setLastName('');

        $serializerMock->method('deserialize')->willReturn($userDTO);
        
        $violations = new ConstraintViolationList([
            new ConstraintViolation('Invalid email', '', [], '', 'email', ''),
            new ConstraintViolation('Empty first name', '', [], '', 'firstName', ''),
            new ConstraintViolation('Empty last name', '', [], '', 'lastName', ''),
        ]);
        $validatorMock->method('validate')->willReturn($violations);

        $controller = new UserController($messageBusMock, $validatorMock, $serializerMock);

        $request = Request::create('/users', 'POST', [], [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'email' => '',
            'firstName' => '',
            'lastName' => '',
        ]));

        $response = $controller->createUser($request, $serializerMock);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testCreateUserSuccessfully(): void
    {
        $messageBusMock = $this->createMock(MessageBusInterface::class);
        $validatorMock = $this->createMock(ValidatorInterface::class);
        $serializerMock = $this->createMock(DTOSerializer::class);

        $userDTO = new CreateUserDTO();
        $userDTO->setEmail('test@example.com');
        $userDTO->setFirstName('John');
        $userDTO->setLastName('Doe');

        $serializerMock->method('deserialize')->willReturn($userDTO);
        $validatorMock->method('validate')->willReturn(new ConstraintViolationList());
        $messageBusMock->method('dispatch')->willReturn(new Envelope(new \stdClass()));

        $controller = new UserController($messageBusMock, $validatorMock, $serializerMock);

        $request = Request::create('/users', 'POST', [], [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ]));

        $response = $controller->createUser($request, $serializerMock);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
}
