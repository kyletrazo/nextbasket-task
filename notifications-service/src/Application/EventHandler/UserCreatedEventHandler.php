<?php
namespace App\Application\EventHandler;

use App\Application\Event\UserCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UserCreatedEventHandler
{
    private $logger;

    public function __construct(LoggerInterface $notificationLogger)
    {
        $this->logger = $notificationLogger;
    }

    public function __invoke(UserCreatedEvent $event)
    {
        // Output on log file
        $this->logger->info('UserCreatedEvent received', [
            'email' => $event->getEmail(),
            'firstName' => $event->getFirstName(),
            'lastName' => $event->getLastName(),
        ]);

        // Output on cli for secondary check if log file is not reflected immediately
        error_log('UserCreatedEvent: ' . $event->getEmail());
    }
}
