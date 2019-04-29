<?php

namespace AppBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class TaskDTO
{
    /**
     * @var string|null
     * @Assert\NotBlank(message="Vous devez saisir un titre.")
     * @Assert\Length(
     *     max=25,
     *     maxMessage="Le titre ne peut pas excéder 25 caractéres."
     * )
     */
    public $title;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Vous devez saisir du contenu.")
     */
    public $content;

    /**
     * AddTaskInput constructor.
     * @param string|null $title
     * @param string|null $content
     */
    public function __construct(
        string $title = null,
        string $content = null
    ) {
        $this->title = $title;
        $this->content = $content;
    }
}
