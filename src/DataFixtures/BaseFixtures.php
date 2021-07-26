<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

abstract class BaseFixtures extends Fixture
{
    /**
     * @var Faker\Generator\
     */
    protected $faker;
    /**
     * @var ObjectManager
     */
    protected $manager;
    public function load(ObjectManager $manager)
    {
        $this->faker = FakerFactory::create();
        $this->manager = $manager;
        $manager->flush();
        $this->loadData($manager);
    }
    abstract function loadData(ObjectManager $manager);

    protected function create(string $className, callable $factory)
    {
        $entity = new $className();
        $factory($entity);

        $this->manager->persist($entity);
        return $entity;
    }

    protected function createMany(string $className, int $count, callable $factory)
    {
        for($i = 0; $i < $count; $i++) {
            $this->create($className, $factory);
        }
        $this->manager->flush();
    }
}
