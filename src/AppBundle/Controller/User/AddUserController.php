<?php

namespace AppBundle\Controller\User;

use AppBundle\Form\CreateUserType;
use AppBundle\Handler\AddUserHandler;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class AddUserController
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var Environment */
    protected $twig;

    /** @var AddUserHandler */
    protected $handler;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        AddUserHandler $addUserHandler,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->handler = $addUserHandler;
        $this->urlGenerator = $urlGenerator;
    }


    /**
     * @Route("/users/create", name="user_create")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public function createAction(Request $request)
    {
        $form = $this->formFactory->create(CreateUserType::class);
        $form->handleRequest($request);

        if ($this->handler->handle($form)) {
            return new RedirectResponse(
                $this->urlGenerator->generate('user_list')
            );
        }

        return new Response(
            $this->twig->render(
                'user/create.html.twig',
                [
                    'form' => $form->createView(),
                ]
            )
        );
    }
}
