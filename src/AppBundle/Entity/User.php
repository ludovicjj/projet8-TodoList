<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(
 *     "email",
 *     message="Cette adresse email déjà utilisé."
 * )
 * @UniqueEntity(
 *     "username",
 *     message="Ce nom d'utilisateur est déjà utilisé."
 * )
 */
class User extends AbstractEntity implements UserInterface
{
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     * @Assert\Length(
     *     max=25,
     *     maxMessage="Votre nom d'utilisateur ne peut pas excéder 25 caractéres."
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Vous devez saisir un mot de passe.")
     * @Assert\Length(
     *     max=64,
     *     maxMessage="Votre mot de passe ne peut pas excéder 64 caractéres."
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Email(message="Le format de l'adresse n'est pas correcte.")
     * @Assert\Length(
     *     max=60,
     *     maxMessage="Votre email ne peut pas excéder 60 caractéres."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Task", mappedBy="user")
     */
    private $tasks;

    /**
     * User constructor.
     * @param string $username
     * @param string $password
     * @param string $email
     * @param bool $roles
     * @throws \Exception
     */
    public function __construct(
        string $username,
        string $password,
        string $email,
        bool $roles
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->roles = ($roles) ? ['ROLE_ADMIN'] : ['ROLE_USER'];
        $this->tasks = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $email
     * @param bool $roles
     */
    public function update(
        string $username,
        string $password,
        string $email,
        bool $roles
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->roles = ($roles) ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return ArrayCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    public function eraseCredentials()
    {
    }
}
