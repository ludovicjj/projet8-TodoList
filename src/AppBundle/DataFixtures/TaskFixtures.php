<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use AppBundle\Factory\Entity\TaskFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $dataTasks = [
            [
                'title' => 'tâche 1',
                'content' => 'Description de la tâche 1',
                'user' => 'admin'
            ],
            [
                'title' => 'tâche 2',
                'content' => 'Description de la tâche 2',
                'user' => 'user1'
            ],
            [
                'title' => 'tâche 3',
                'content' => 'Description de la tâche 3',
                'user' => 'user2'
            ],
            [
                'title' => 'tâche 4',
                'content' => 'Une tâche créé par un utilisateur anonyme',
                'user' => 'anonymous'
            ]
        ];

        foreach ($dataTasks as $dataTask) {

            /** @var User $user */
            $user = ($this->hasReference($dataTask['user'])) ? $this->getReference($dataTask['user']) : null;

            $task = TaskFactory::create(
                $dataTask['title'],
                $dataTask['content'],
                $user
            );

            $manager->persist($task);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
