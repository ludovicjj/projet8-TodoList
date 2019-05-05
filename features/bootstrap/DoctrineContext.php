<?php

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\ToolsException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Behat\Gherkin\Node\TableNode;
use AppBundle\Factory\Entity\UserFactory;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

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
}
