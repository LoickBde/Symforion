<?php


namespace App\DataFixtures;
use App\Entity\Student;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 40; $i++) {
            $student = new Student();
            $student->setEmail($faker->email);
            $student->setPassword("Eleve123");
            $student->setLastname($faker->name());
            $student->setFirstname($faker->firstName());
            $manager->persist($student);
            $this->addReference("student_$i",$student);
        }
        $manager->flush();
    }
}