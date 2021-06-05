<?php


namespace App\DataFixtures;

use App\Entity\Promo;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PromoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $promoLE1 = new Promo();
        $promoLE1->setName("LE1");
        for($i = 0; $i < 20; $i++){
            $student = $this->getReference("student_$i");
            $promoLE1->addStudent($student);
        }
        $manager->persist($promoLE1);
        $this->addReference("promo_LE1", $promoLE1);
        $manager->flush();

        $promoLE2 = new Promo();
        $promoLE2->setName("LE2");
        for($i = 20; $i < 40; $i++){
            $student = $this->getReference("student_$i");
            $promoLE2->addStudent($student);
        }
        $manager->persist($promoLE2);
        $this->addReference("promo_LE2", $promoLE2);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StudentFixtures::class
        ];
    }
}