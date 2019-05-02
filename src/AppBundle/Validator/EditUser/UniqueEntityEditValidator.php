<?php

namespace AppBundle\Validator\EditUser;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\Request;

class UniqueEntityEditValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var Request|null  */
    protected $currentRequest;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ) {
        $this->entityManager = $entityManager;
        $this->currentRequest = $requestStack->getCurrentRequest();
    }

    public function getUserUpdated()
    {
        $currentRequest = (!\is_null($this->currentRequest)) ? $this->currentRequest : null;

        if (is_null($currentRequest)) {
            throw new AccessDeniedHttpException('You must be login.');
        }

        $oldUser = $this->entityManager->getRepository(User::class)
            ->findOneBy(
                [
                    'id' => $currentRequest->attributes->get('id'),
                ]
            );

        return $oldUser;
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

        $oldUser = $this->getUserUpdated();

        /** @var User|null $object1 */
        $object1 = $this->entityManager->getRepository($constraint->class)
            ->findOneBy(
                [
                    'username' => $entity->username,
                ]
            );

        /** @var User|null $object2 */
        $object2 = $this->entityManager->getRepository($constraint->class)
            ->findOneBy(
                [
                    'email' => $entity->email,
                ]
            );

        if (!\is_null($object1)) {
            if ($oldUser->getUsername() !== $object1->getUsername()) {
                $this->context->buildViolation("Ce nom d'utilisateur est déjà utilisé.")
                    ->atPath('username')
                    ->addViolation();
            }
        }

        if (!\is_null($object2)) {
            if ($oldUser->getEmail() !== $object2->getEmail()) {
                $this->context->buildViolation("Cette email est déjà utilisée.")
                    ->atPath('email')
                    ->addViolation();
            }
        }
    }
}
