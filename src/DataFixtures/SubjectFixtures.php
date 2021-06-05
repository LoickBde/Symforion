<?php


namespace App\DataFixtures;


use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $subjectsName = ['Mathématiques', 'Méacanique', 'Algorithmie', 'SDA', 'Micro-informatique', 'Web'];

        foreach ($subjectsName as $str){
            $subject = new Subject();
            $subject->setName($str);
            $manager->persist($subject);
            $this->addReference("subject_$str", $subject);
        }
        $manager->flush();
    }
}