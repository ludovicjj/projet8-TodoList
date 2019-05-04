<?php

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\ToolsException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Behat\Gherkin\Node\TableNode;
use AppBundle\Factory\Entity\UserFactory;
use AppBundle\Entity\User;

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
}
