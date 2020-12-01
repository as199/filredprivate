<?php

namespace App\DataFixtures;

use App\Entity\GroupeTags;
use App\Entity\Tags;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $groupTags =["groupeTag1","groupeTag2","groupeTag3"];
        foreach ($groupTags as $key =>$groupTag){
            $newGroupTag = new GroupeTags();
            $newGroupTag->setLibelle($groupTag);
            $tags =["tag1","tag2","tag3","tag4"];
            foreach ($tags as $keys => $libelle) {
                $tag = new  Tags();
                $tag->setLibelle($libelle."".$key)
                    ->setDescriptif("descriptif ".$libelle."".$key);
                $manager->persist($tag);
                $newGroupTag->addTag($tag);
                $manager->persist($newGroupTag);
            }
        }


        $manager->flush();
    }
}
