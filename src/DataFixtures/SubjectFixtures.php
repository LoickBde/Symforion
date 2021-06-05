<?php


namespace App\DataFixtures;


use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $subjectsName = ['Mathématiques', 'Mécanique', 'Algorithmie', 'SDA', 'Micro-informatique', 'Web'];

        foreach ($subjectsName as $str){
            $cnt = 0;
            $subject = new Subject();
            $subject->setName($str);
            $teacher = $this->getReference("teacher_$cnt");
            $subject->setTeacher($teacher);
            $cnt ++;
            $manager->persist($subject);
            $this->addReference("subject_$str", $subject);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TeacherFixtures::class,
        ];
    }
}