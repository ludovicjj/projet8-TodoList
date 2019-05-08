<?php

namespace AppBundle\Form;

use AppBundle\DTO\EditUserDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditUserDTO::class,
        ]);
    }

    public function getParent()
    {
        return CreateUserType::class;
    }
}
