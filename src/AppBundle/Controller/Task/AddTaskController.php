<?php

namespace AppBundle\Controller\Task;

use AppBundle\Form\TaskType;
use AppBundle\Handler\AddTaskHandler;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class AddTaskController
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var Environment */
    protected $twig;

    /** @var AddTaskHandler */
    protected $handler;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        UrlGeneratorInterface $urlGenerator,
        AddTaskHandler $addTaskHandler
    ) {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
        $this->handler = $addTaskHandler;
    }

    /**
     * @Route("/tasks/create", name="task_create")
     * @param Request $request
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public function createAction(Request $request)
    {
        $form = $this->formFactory->create(TaskType::class);
        $form->handleRequest($request);

        if ($this->handler->handle($form)) {
            return new RedirectResponse(
                $this->urlGenerator->generate('task_list').'?search=waiting'
            );
        }

        return new Response(
            $this->twig->render(
                'task/create.html.twig',
                [
                    'form' => $form->createView(),
                ]
            )
        );
    }
}
