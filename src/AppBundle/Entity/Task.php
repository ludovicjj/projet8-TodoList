<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaskRepository")
 * @ORM\Table(name="task")
 */
class Task extends AbstractEntity
{
    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="Vous devez saisir un titre.")
     * @Assert\Length(
     *     max=25,
     *     maxMessage="Le titre ne peut pas excéder 25 caractéres."
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez saisir du contenu.")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDone;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;

    /**
     * Task constructor.
     * @param string $title
     * @param string $content
     * @param User|null $user
     * @throws \Exception
     */
    public function __construct(
        string $title,
        string $content,
        $user
    ) {
        $this->title = $title;
        $this->content = $content;
        $this->user = $user;
        $this->isDone = false;
        parent::__construct();
    }

    /**
     * @param string $title
     * @param string $content
     */
    public function update(
        string $title,
        string $content
    ) {
        $this->title = $title;
        $this->content =$content;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return bool
     */
    public function isDone()
    {
        return $this->isDone;
    }

    /**
     * @param bool $flag
     */
    public function toggle($flag)
    {
        $this->isDone = $flag;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }
}
