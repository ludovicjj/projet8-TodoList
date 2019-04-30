<?php

namespace AppBundle\Handler;


use AppBundle\Builder\AddUserBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class AddUserHandler
{
    /** @var AddUserBuilder */
    protected $builder;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var FlashBagInterface */
    protected $flashBag;

    public function __construct(
        AddUserBuilder $addUserBuilder,
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag
    ) {
        $this->builder = $addUserBuilder;
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }

    /**
     * @param FormInterface $form
     * @return bool
     * @throws \Exception
     */
    public function handle(FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->builder->build($form->getData());
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->flashBag->add('success', "L'utilisateur a bien été ajouté.");

            return true;
        }

        return false;
    }
}
