<?php

namespace AppBundle\Helper\RequestResolver\Task;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;

abstract class AbstractRequestResolver
{
    /** @var array */
    const ALLOW_PARAMS = ['done', 'waiting'];

    /** @var string */
    protected $routeParam;

    /** @var string */
    protected $valueParam;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /** @var Security */
    protected $security;

    /** @var Task */
    protected $task;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        Security $security
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->security = $security;
    }

    /**
     * @param Request $request
     */
    protected function checkQueryParam(Request $request)
    {
        $valueParam = $request->query->get('search', 'waiting');

        // Check if query param "search" has an allow value
        if (!\in_array($valueParam, self::ALLOW_PARAMS)) {
            $valueParam = 'waiting';
        }

        $this->routeParam = '?search='.$valueParam;
        $this->valueParam = $valueParam;
    }

    /**
     * @return User|null
     */
    private function getCurrentUser()
    {
        /** @var TokenInterface|null $token */
        $token = $this->tokenStorage->getToken();

        /** @var User|null $user */
        $user = (!\is_null($token)) ? $token->getUser() : null;

        return $user;
    }

    /**
     * @param string $message
     */
    protected function checkAllowUser(string $message)
    {
        if (
            $this->task->getUser() !== $this->getCurrentUser() &&
            !$this->security->isGranted('ROLE_ADMIN')
        ) {
            throw new AccessDeniedHttpException($message);
        }
    }

    /**
     * @param Request $request
     */
    protected function checkTaskExist(Request $request)
    {
        /** @var Task|null $task */
        $task = $this->entityManager
            ->getRepository(Task::class)
            ->findOneBy(
                [
                    'id' => $request->attributes->get('id'),
                ]
            );

        if (\is_null($task)) {
            throw new NotFoundHttpException(
                sprintf('Not found task with id : %s', $request->attributes->get('id'))
            );
        }

        $this->task = $task;
    }

    /**
     * @return string
     */
    public function getRouteParam()
    {
        return $this->routeParam;
    }

    /**
     * @return string
     */
    public function getValueParam()
    {
        return $this->valueParam;
    }

    /**
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }
}
