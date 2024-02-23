<?php 
namespace App\EventListener;

use App\Entity\User;
use App\Application\Event\UserCreatedEvent;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Symfony\Component\Messenger\MessageBusInterface;

class UserListener
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function postPersist(User $user, PostPersistEventArgs $event): void
    {
        $entity = $event->getObject();
        
        if ($entity instanceof $user) {
            $event = new UserCreatedEvent($entity->getEmail(), $entity->getFirstName(), $entity->getLastName());
            $this->messageBus->dispatch($event);
        }
    }
}
