<?php

namespace AppBundle\Handler;

use AppBundle\Builder\EditUserBuilder;
use AppBundle\Entity\User;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class EditUserHandler
{
    /** @var EditUserBuilder */
    protected $builder;

    /** @var FlashBagInterface */
    protected $flashBag;

    public function __construct(
        EditUserBuilder $editUserBuilder,
        FlashBagInterface $flashBag
    ) {
        $this->builder = $editUserBuilder;
        $this->flashBag = $flashBag;
    }

    /**
     * @param FormInterface $form
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function handle(FormInterface $form, User $user)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->builder->build($form->getData(), $user);
            $this->flashBag->add('success', "L'utilisateur a bien été modifié");
            return true;
        }

        return false;
    }
}