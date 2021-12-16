<?php

namespace App\DataFixtures;

use App\Factory\ApplicationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ApplicationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ApplicationFactory::createMany(20);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ShopFixtures::class,
            CategoryFixtures::class,
            WhereFixtures::class
        ];
    }
}
