<?php

namespace AppBundle\Validator\EditUser;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueEntityEditValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var RequestStack  */
    protected $requestStack;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ) {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public function getUserUpdated()
    {
        $userUpdate = $this->entityManager->getRepository(User::class)
            ->findOneBy(
                [
                    'id' => $this->requestStack->getCurrentRequest()->attributes->get('id'),
                ]
            );

        return $userUpdate;
    }

    public function validate(
        $entity,
        Constraint $constraint
    ) {
        if (!$constraint instanceof UniqueEntityEdit) {
            throw new UnexpectedTypeException($constraint, UniqueEntityEdit::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $entity || '' === $entity) {
            return;
        }

        $temoin = $this->getUserUpdated();

        $object1 = $this->entityManager->getRepository($constraint->class)
            ->findOneBy(
                [
                    'username' => $entity->username,
                ]
            );

        $object2 = $this->entityManager->getRepository($constraint->class)
            ->findOneBy(
                [
                    'email' => $entity->email,
                ]
            );

        if(!\is_null($object1)) {
            if ($temoin->getUsername() !== $object1->getUsername()) {
                $this->context->buildViolation("Ce nom d'utilisateur est déjà utilisé.")
                    ->atPath('username')
                    ->addViolation();
            }
        }

        if(!\is_null($object2)) {
            if ($temoin->getEmail() !== $object2->getEmail()) {
                $this->context->buildViolation("Cette email est déjà utilisée.")
                    ->atPath('email')
                    ->addViolation();
            }
        }
    }
}
