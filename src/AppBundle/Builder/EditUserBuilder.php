<?php

namespace AppBundle\Builder;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use AppBundle\DTO\EditUserDTO;
use AppBundle\Entity\User;

class EditUserBuilder
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var EncoderFactoryInterface */
    protected $encoderFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->entityManager = $entityManager;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param EditUserDTO $dto
     * @param User $user
     * @throws \Exception
     */
    public function build(EditUserDTO $dto, User $user)
    {
        $user->update(
            $dto->username,
            $this->encoderFactory->getEncoder(User::class)->encodePassword($dto->password, ''),
            $dto->email,
            $dto->roles
        );

        $user->onUpdatedAt();

        $this->entityManager->flush();
    }
}
