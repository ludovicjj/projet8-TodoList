<?php

namespace AppBundle\Validator\CreateUser;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueEntityValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * UniqueEntityInputValidator constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function validate(
        $value,
        Constraint $constraint
    ) {
        if (!$constraint instanceof UniqueEntity) {
            throw new UnexpectedTypeException($constraint, UniqueEntity::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        $object = $this->entityManager->getRepository($constraint->class)
            ->findOneBy(
                [
                    $constraint->fields => $value,
                ]
            );

        if ($object) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
