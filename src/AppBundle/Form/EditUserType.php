<?php

namespace AppBundle\Form;

use AppBundle\DTO\EditUserDTO;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserType extends CreateUserType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditUserDTO::class,
        ]);
    }
}