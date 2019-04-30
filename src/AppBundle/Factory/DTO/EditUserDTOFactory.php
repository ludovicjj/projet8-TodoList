<?php

namespace AppBundle\Factory\DTO;

use AppBundle\DTO\EditUserDTO;
use AppBundle\Entity\User;

class EditUserDTOFactory
{
    /**
     * @param User $user
     * @return EditUserDTO
     */
    public static function create(User $user)
    {
        $dto = new EditUserDTO(
            $user->getUsername(),
            $user->getEmail(),
            ($user->getRoles() === ['ROLE_ADMIN']) ? true : false
        );

        return $dto;
    }
}
