<?php

namespace AppBundle\Controller\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class ListUserController
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var Environment */
    protected $twig;

    public function __construct(
        EntityManagerInterface $entityManager,
        Environment $twig
    ) {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    /**
     * @Route("/users", name="user_list")
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function listAction()
    {
        return new Response(
            $this->twig->render(
                'user/list.html.twig',
                [
                    'users' => $this->entityManager->getRepository('AppBundle:User')->findAll()
                ]
            )
        );
    }
}
