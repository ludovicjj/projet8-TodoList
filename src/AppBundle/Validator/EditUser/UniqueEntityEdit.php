<?php

namespace AppBundle\Validator\EditUser;

use Symfony\Component\Validator\Constraint;

/**
 * Class UniqueEntityEdit
 * @package AppBundle\Validator\EditUser
 * @Annotation
 */
class UniqueEntityEdit extends Constraint
{
    public $message = "this value should be unique";
    public $class;
    public $fields = [];

    public function getRequiredOptions()
    {
        return [
            'fields',
            'class',
        ];
    }

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
