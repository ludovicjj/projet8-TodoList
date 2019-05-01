<?php

namespace AppBundle\Handler;

use AppBundle\Builder\AddTaskBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class AddTaskHandler
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var FlashBagInterface */
    protected $flashBag;

    /** @var AddTaskBuilder */
    protected $builder;

    public function __construct(
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag,
        AddTaskBuilder $addTaskBuilder
    ) {
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
        $this->builder = $addTaskBuilder;
    }

    /**
     * @param FormInterface $form
     * @return bool
     * @throws \Exception
     */
    public function handle(FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $task = $this->builder->build($form->getData());
            $this->entityManager->persist($task);
            $this->entityManager->flush();
            $this->flashBag->add('success', 'La tâche a été bien été ajoutée.');

            return true;
        }

        return false;
    }
}
