<?php

namespace AppBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\CreateUser\UniqueEntity;

class CreateUserDTO
{
    /**
     * @var string|null
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     * @Assert\Length(
     *     max=25,
     *     maxMessage="Votre nom d'utilisateur ne peut pas excéder 25 caractéres."
     * )
     * @UniqueEntity(
     *     class="AppBundle\Entity\User",
     *     fields="username",
     *     message="Ce nom d'utilisateur est déjà utilisé."
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
     * @var string|null
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Email(message="Le format de l'adresse n'est pas correcte.")
     * @Assert\Length(
     *     max=60,
     *     maxMessage="Votre email ne peut pas excéder 60 caractéres."
     * )
     * @UniqueEntityInput(
     *     class="AppBundle\Entity\User",
     *     fields="email",
     *     message="Cette email est déjà utilisée."
     * )
     */
    public $email;

    /**
     * @var bool|null
     */
    public $roles;

    /**
     * AddUserInput constructor.
     * @param string|null $username
     * @param string|null $password
     * @param string|null $email
     * @param bool|null $roles
     */
    public function __construct(
        string $username = null,
        string $password = null,
        string $email = null,
        bool $roles = null
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->roles = $roles;
    }
}
