<?php

namespace App\DataFixtures;

use App\Entity\Where;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WhereFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $wheres = [
            'ULOTKA',
            'PLAKAT W SKLEPIE',
            'ZAWIESZKA PRODUKTOWA',
            'REKLAMA W INTERNECIE',
            'WIZAŻ.PL',
            'BLOG',
            'MAILING NA SKRZYNCE',
            'FACEBOOK',
            'INNE',
        ];

        foreach ($wheres as $item) {
            $where = new Where();
            $where->setName($item);
            $manager->persist($where);
            $manager->flush();
        }
    }
}
