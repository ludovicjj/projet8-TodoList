<?php

namespace AppBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\EditUser\UniqueEntityEdit;

/**
 * Class EditUserDTO
 * @package AppBundle\DTO
 * @UniqueEntityEdit(
 *     class="AppBundle\Entity\User",
 *     fields={"username", "email"},
 *     message="this value is already used"
 * )
 */
class EditUserDTO
{
    /**
     * @var string
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     * @Assert\Length(
     *     max=25,
     *     maxMessage="Votre nom d'utilisateur ne peut pas excéder 25 caractéres."
     * )
     */
    public $username;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Vous devez saisir un mot de passe.")
     * @Assert\Length(
     *     max=64,
     *     maxMessage="Votre mot de passe ne peut pas excéder 64 caractéres."
     * )
     */
    public $password;

    /**
     * @var string
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     * @Assert\Email(message="Le format de l'adresse n'est pas correcte.")
     * @Assert\Length(
     *     max=60,
     *     maxMessage="Votre email ne peut pas excéder 60 caractéres."
     * )
     */
    public $email;

    /**
     * @var bool
     */
    public $roles;

    public function __construct(
        string $username,
        string $email,
        bool $roles,
        string $password = null
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->roles = $roles;
    }
}
