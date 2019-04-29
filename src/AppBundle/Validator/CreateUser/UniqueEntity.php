<?php

namespace AppBundle\Validator\CreateUser;

use Symfony\Component\Validator\Constraint;

/**
 * Class UniqueEntity
 * @package AppBundle\Validator\CreateUser
 * @Annotation
 */
class UniqueEntity extends Constraint
{
    public $message = "this value should be unique";
    public $class;
    public $fields;

    public function getRequiredOptions()
    {
        return [
            'fields',
            'class',
        ];
    }
}
