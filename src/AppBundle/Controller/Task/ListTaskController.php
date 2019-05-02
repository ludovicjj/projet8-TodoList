<?php

namespace AppBundle\Controller\Task;

use AppBundle\Entity\Task;
use AppBundle\Helper\RequestResolver\Task\ListTask\RequestResolver;
use AppBundle\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class ListTaskController
{
    /** @var Environment */
    protected $twig;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var RequestResolver */
    protected $resolver;

    public function __construct(
        Environment $twig,
        EntityManagerInterface $entityManager,
        RequestResolver $requestResolver
    ) {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->resolver = $requestResolver;
    }

    /**
     * @Route("/tasks", name="task_list")
     * @param Request $request
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function listAction(Request $request)
    {
        /** @var bool $isDone */
        $isDone = $this->resolver->resolve($request);

        /** @var TaskRepository $taskRepository */
        $taskRepository = $this->entityManager->getRepository(Task::class);

        /** @var array $tasks */
        $tasks = $taskRepository->getAllTaskByDone($isDone);

        return new Response(
            $this->twig->render(
                'task/list.html.twig',
                [
                    'tasks' => $tasks,
                ]
            )
        );
    }
}
