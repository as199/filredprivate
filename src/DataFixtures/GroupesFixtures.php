<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $competences =["SQL","PHP","CSS","JS"];
        foreach ($competences as $libelle){
            $competence = new Competence();
            $competence->setLibelle($libelle);
            $manager->persist($competence);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
