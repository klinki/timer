<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\Repository\TaskRepository;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Listener listening to REGISTRATION_COMPLETED event
 *
 * Class UserRegistrationListener
 * @package AppBundle\EventListener
 */
class UserRegistrationListener implements EventSubscriberInterface
{
    /** @var  TaskRepository */
    protected $taskRepository;

    /**
     * UserRegistrationListener constructor.
     *
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Subscribe for events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_COMPLETED => 'onUserRegistered'
        ];
    }

    /**
     * Event automatically fired when user is registered
     *
     * @param FilterUserResponseEvent $event
     */
    public function onUserRegistered(FilterUserResponseEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser();
        $name = 'Unasigned actions';

        $task = new Task($name, $user);
        $task->setDefault(true);

        $this->taskRepository->save($task);
    }
}
