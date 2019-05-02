<?php

namespace AppBundle\Handler;

use AppBundle\Builder\EditTaskBuilder;
use AppBundle\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class EditTaskHandler
{
    /** @var FlashBagInterface */
    protected $flashBag;

    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(
        FlashBagInterface $flashBag,
        EntityManagerInterface $entityManager
    ) {
        $this->flashBag = $flashBag;
        $this->entityManager = $entityManager;
    }

    /**
     * @param FormInterface $form
     * @param Task $task
     * @return bool
     * @throws \Exception
     */
    public function handle(FormInterface $form, Task $task)
    {
        if ($form->isSubmitted() && $form->isValid())
        {
            EditTaskBuilder::build($form->getData(), $task);
            $this->entityManager->flush();
            $this->flashBag->add('success', 'La tâche a bien été modifiée.');

            return true;
        }

        return false;
    }
}
