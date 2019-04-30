<?php

namespace AppBundle\Helper\RequestResolver\User;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequestResolver
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @return User
     */
    public function resolve(Request $request)
    {
        /** @var User|null $user */
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(
                [
                    'id' => $request->attributes->get('id'),
                ]
            );

        if (\is_null($user)) {
            throw new NotFoundHttpException(
                sprintf('Not found user with id : %s', $request->attributes->get('id'))
            );
        }

        return $user;
    }
}
