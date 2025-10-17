<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function getDependencies():array
    {
        return [
            CategoryFixtures::class,
        ];
    }
    
    public function load(ObjectManager $manager): void
    {
        $visE = new Product();
        $visE->setLabel("vis étoile");
        $visE->setPriceHt(10);
        $visE->setPriceTva(2);
        $visE->setPriceTtc(12);
        $visE->addCategory($this->getReference
        (CategoryFixtures::CATEGORY_QUINCAILLERIE,
        Category::class)
        );
       
        $manager->persist($visE);

        $visA = new Product();
        $visA->setLabel("vis allen");
        $visA->setPriceHt(15);
        $visA->setPriceTva(3);
        $visA->setPriceTtc(18);
        $visA->addCategory($this->getReference
        (CategoryFixtures::CATEGORY_QUINCAILLERIE,
        Category::class)
        );
        $manager->persist($visA);

        $manager->flush();
    }
}
