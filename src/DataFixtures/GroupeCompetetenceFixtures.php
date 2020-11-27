<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use App\Entity\GroupeCompetence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupeCompetetenceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tabDev = ['html', 'php', 'javascript', 'mysql', 'Anglais des affaires', 'Marketing', 'Community management'];
        $tabLibelle = ['Developpement web', 'Gestions'];
        $tabDescriptif = ['Descritif en Developpement web', 'Descritif en Gestion'];
        for ($j = 0; $j < count($tabLibelle); $j++) {
            $grpcompetences1 = new GroupeCompetence();
            $grpcompetences1->setLibelle($tabLibelle[$j])
                ->setDescriptif($tabDescriptif[$j]);
            $manager->persist($grpcompetences1);
            for ($i = 0; $i < count($tabDev); $i++) {
                $competences = new Competence();
                $competences->setLibelle($tabDev[$i])
                    ->addGroupeCompetence($grpcompetences1);
                $manager->persist($competences);
            }
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}