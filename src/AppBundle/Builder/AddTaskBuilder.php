<?php

namespace AppBundle\Builder;

use AppBundle\DTO\TaskDTO;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AddTaskBuilder
{
    /** @var TokenStorageInterface */
    protected $tokenStorage;

    public function __construct(
        TokenStorageInterface $tokenStorage
    ) {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return User|null
     */
    private function getCurrentUser()
    {
        $token = $this->tokenStorage->getToken();
        $currentUser = (\is_null($token)) ? null : $token->getUser();

        /** @var User|null $user */
        $user = (\is_object($currentUser)) ? $currentUser : null;

        return $user;
    }

    /**
     * @param TaskDTO $dto
     * @return Task
     * @throws \Exception
     */
    public function build(TaskDTO $dto)
    {
        $task = new Task(
            $dto->title,
            $dto->content,
            $this->getCurrentUser()
        );

        return $task;
    }
}
