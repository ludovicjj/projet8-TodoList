<?php

namespace AppBundle\Controller\Task;

use AppBundle\Builder\ToggleTaskBuilder;
use AppBundle\Helper\RequestResolver\Task\ToggleTask\RequestResolver;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;

class ToggleTaskController
{
    /** @var RequestResolver */
    protected $resolver;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    /** @var ToggleTaskBuilder */
    protected $builder;

    public function __construct(
        RequestResolver $requestResolver,
        UrlGeneratorInterface $urlGenerator,
        ToggleTaskBuilder $toggleTaskBuilder
    ) {
        $this->resolver = $requestResolver;
        $this->urlGenerator = $urlGenerator;
        $this->builder = $toggleTaskBuilder;
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     * @param Request $request
     * @return RedirectResponse
     */
    public function toggleTaskAction(Request $request)
    {
        $this->resolver->resolve($request);
        $this->builder->toggle($this->resolver->getTask());
        return new RedirectResponse(
            $this->urlGenerator->generate('task_list').$this->resolver->getRouteParam()
        );
    }
}
