<?php

namespace AppBundle\Controller\Task;

use AppBundle\Builder\DeleteTaskBuilder;
use AppBundle\Helper\RequestResolver\Task\DeleteTask\RequestResolver;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DeleteTaskController
{
    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    /** @var RequestResolver */
    protected $resolver;

    /** @var DeleteTaskBuilder */
    protected $builder;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        RequestResolver $requestResolver,
        DeleteTaskBuilder $deleteTaskBuilder
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->resolver = $requestResolver;
        $this->builder = $deleteTaskBuilder;
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteTaskAction(Request $request)
    {
        $this->resolver->resolve($request);
        $this->builder->delete($this->resolver->getTask());

        return new RedirectResponse(
            $this->urlGenerator->generate('task_list').$this->resolver->getRouteParam()
        );
    }
}
