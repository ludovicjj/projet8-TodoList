<?php

namespace AppBundle\Controller\Task;

use AppBundle\DTO\TaskDTO;
use AppBundle\Factory\DTO\TaskDTOFactory;
use AppBundle\Form\TaskType;
use AppBundle\Handler\EditTaskHandler;
use AppBundle\Helper\RequestResolver\Task\EditTask\RequestResolver;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class EditTaskController
{
    /** @var Environment */
    protected $twig;

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var RequestResolver */
    protected $resolver;

    /** @var EditTaskHandler */
    protected $handler;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;
    
    public function __construct(
        Environment $twig,
        FormFactoryInterface $formFactory,
        RequestResolver $requestResolver,
        EditTaskHandler $editTaskHandler,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->resolver = $requestResolver;
        $this->handler = $editTaskHandler;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public function editAction(Request $request)
    {
        $this->resolver->resolve($request);

        /** @var TaskDTO $taskDTO */
        $taskDTO = TaskDTOFactory::create($this->resolver->getTask());

        $form = $this->formFactory->create(TaskType::class, $taskDTO);
        $form->handleRequest($request);

        if ($this->handler->handle($form, $this->resolver->getTask())) {
            return new RedirectResponse(
                $this->urlGenerator->generate('task_list').$this->resolver->getRouteParam()
            );
        }

        return new Response(
            $this->twig->render(
                'task/edit.html.twig',
                [
                    'form' => $form->createView(),
                    'task' => $this->resolver->getTask(),
                ]
            )
        );
    }
}
