<?php


namespace App\DataFixtures;
use App\Entity\Promo;
use App\Entity\Teacher;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class TeacherFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $subjectsName = ['Mathématiques', 'Méacanique', 'Algorithmie', 'SDA', 'Micro-informatique', 'Web'];
        $promoLE1 = $this->getReference("Promo_LE1");
        $promoLE2 = $this->getReference("Promo_LE2");

        for ($i = 0; $i < 5; $i++) {
            $teacher = new Teacher();
            $teacher->setEmail($faker->email);
            $teacher->setPassword("Prof123");
            $teacher->setLastname($faker->name());
            $teacher->setFirstname($faker->firstName());
            $teacher->addPromo($promoLE1);
            $teacher->addPromo($promoLE2);
            foreach ($subjectsName as $str){
                $subject = $this->getReference("subject_$str");
                $teacher->addSubject($subject);
            }
            $manager->persist($teacher);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            Promo::class
        ];
    }
}