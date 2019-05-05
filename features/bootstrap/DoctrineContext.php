<?php

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\ToolsException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Behat\Gherkin\Node\TableNode;
use AppBundle\Factory\Entity\UserFactory;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use AppBundle\Entity\AbstractEntity;
use AppBundle\Entity\Task;

class DoctrineContext implements Context
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var KernelInterface */
    private $kernel;

    /** @var EncoderFactoryInterface| EncoderFactory */
    private $encoderFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        KernelInterface $kernel,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->entityManager = $entityManager;
        $this->kernel = $kernel;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @BeforeScenario
     * @throws ToolsException
     */
    public function clearDatabase()
    {
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $schemaTool->dropSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
        $schemaTool->createSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @Given I load the following user
     * @param TableNode $table
     * @throws Exception
     */
    public function iLoadTheFollowingUser(TableNode $table)
    {
        foreach ($table->getHash() as $hash) {
            $user = UserFactory::create(
                $hash['username'],
                $this->encoderFactory->getEncoder(User::class)->encodePassword($hash['password'], ''),
                $hash['email'],
                (bool) $hash['roles']
            );

            $this->entityManager->persist($user);
        }
        $this->entityManager->flush();
    }

    /**
     * @Then user with username :username should exist in database and have the following role :role
     * @param $username
     * @param $role
     * @throws Exception
     */
    public function userWithUsernameShouldExistInDatabaseAndHaveTheFollowingRole($username, $role)
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['username' => $username]);

        if (\is_null($user)) {
            throw new NotFoundHttpException(
                sprintf('Not found user with username : %s', $username)
            );
        }

        if (!\in_array($role, $user->getRoles())) {
            throw new \Exception(
                sprintf(
                    'User with username %s should have the following role : %s',
                    $username,
                    $role
                )
            );
        }
    }

    /**
     * @Given I load fixtures with the following command :command
     * @param $command
     * @throws Exception
     */
    public function iLoadFixturesWithTheFollowingCommand($command)
    {
        $application = new Application($this->kernel);

        $application->setAutoExit(false);
        $input = new ArrayInput([
            'command' => $command,
            '--no-interaction' => true,
        ]);
        $output = new \Symfony\Component\Console\Output\NullOutput();
        $application->run($input, $output);
    }

    /**
     * @Given user with username :username should have following id :userId
     * @param $username
     * @param $userId
     * @throws NonUniqueResultException
     * @throws ReflectionException
     */
    public function userWithUsernameShouldHaveFollowingId($username, $userId)
    {
        $user = $this->entityManager->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.username = :user_username')
            ->setParameter('user_username', $username)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (\is_null($user)) {
            throw new NotFoundHttpException(
                sprintf('Not found user with username %s', $username)
            );
        }

        $this->resetId($user, $userId);
    }

    /**
     * @Given task with title :arg1 should have following id :arg2
     * @param $title
     * @param $taskId
     * @throws ReflectionException
     * @throws NonUniqueResultException
     */
    public function taskWithTitleShouldHaveFollowingId($title, $taskId)
    {
        $task = $this->entityManager->getRepository(Task::class)
            ->createQueryBuilder('t')
            ->where('t.title = :task_title')
            ->setParameter('task_title', $title)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (\is_null($task)) {
            throw new NotFoundHttpException(
                sprintf('Not found task with title %s', $task)
            );
        }

        $this->resetId($task, $taskId);
    }

    /**
     * @param AbstractEntity $entity
     * @param string $identifier
     * @throws ReflectionException
     */
    protected function resetId(AbstractEntity $entity, string $identifier)
    {
        $reflection = new \ReflectionClass($entity);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($entity, $identifier);
        $this->entityManager->flush();
    }
}
