<?php
namespace App\Application\Event;

class UserCreatedEvent
{
    private $email;
    private $firstName;
    private $lastName;

    public function __construct($email, $firstName, $lastName)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getlastName()
    {
        return $this->lastName;
    }
}