<?php

namespace AppBundle\Builder;

use AppBundle\DTO\CreateUserDTO;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AddUserBuilder
{
    /** @var EncoderFactoryInterface */
    protected $encoderFactory;

    public function __construct(
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param CreateUserDTO $dto
     * @return User
     * @throws \Exception
     */
    public function build(CreateUserDTO $dto)
    {
        $user = new User(
            $dto->username,
            $this->encoderFactory->getEncoder(User::class)->encodePassword($dto->password, ''),
            $dto->email,
            $dto->roles
        );

        return $user;
    }
}
