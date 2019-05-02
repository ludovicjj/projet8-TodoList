<?php

namespace AppBundle\Builder;

use AppBundle\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class DeleteTaskBuilder
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
     */
    public function delete(Task $task)
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();
        $this->flashBag->add('success', 'La tâche a bien été supprimée.');
    }
}
