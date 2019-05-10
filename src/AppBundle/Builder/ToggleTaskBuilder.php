<?php

namespace AppBundle\Builder;

use AppBundle\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ToggleTaskBuilder
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var FlashBagInterface */
    protected $flashBag;

    public function __construct(
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag
    ) {
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }

    /**
     * @param Task $task
     * @param string $valueParam
     */
    public function toggle(Task $task, string $valueParam)
    {
        $task->toggle(!$task->isDone());
        $this->entityManager->flush();

        $statusTask = ($valueParam == 'done') ? 'non terminée' : 'faite';

        $this->flashBag->add(
            'success',
            sprintf('La tâche %s a bien été marquée comme %s.', $task->getTitle(), $statusTask)
        );
    }
}
