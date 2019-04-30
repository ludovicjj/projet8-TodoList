<?php

namespace AppBundle\Controller\User;

use AppBundle\Factory\DTO\EditUserDTOFactory;
use AppBundle\Form\EditUserType;
use AppBundle\Handler\EditUserHandler;
use AppBundle\Helper\RequestResolver\User\RequestResolver;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class EditUserController
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var Environment */
    protected $twig;

    /** @var RequestResolver */
    protected $requestResolver;

    /** @var EditUserHandler */
    protected $handler;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        RequestResolver $requestResolver,
        EditUserHandler $editUserHandler,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->requestResolver = $requestResolver;
        $this->handler = $editUserHandler;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public function editAction(Request $request)
    {
        $user = $this->requestResolver->resolve($request);
        $editUserDTO = EditUserDTOFactory::create($user);

        $form = $this->formFactory->create(EditUserType::class, $editUserDTO);
        $form->handleRequest($request);

        if ($this->handler->handle($form, $user)) {
            return new RedirectResponse(
                $this->urlGenerator->generate('user_list')
            );
        }

        return new Response(
            $this->twig->render(
                'user/edit.html.twig',
                [
                    'form' => $form->createView(),
                    'user' => $user,
                ]
            )
        );
    }
}
