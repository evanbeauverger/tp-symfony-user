<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_QUINCAILLERIE = 'quincaillerie';
    public const CATEGORY_CUISINE = 'cuisine';

    public function load(ObjectManager $manager): void
    {
        $quincaillerie = new Category();
        $quincaillerie->setLabel("Quincaillerie");
        $manager->persist($quincaillerie);

        $cuisine = new Category();
        $cuisine->setLabel("Cuisine");
        $manager->persist($cuisine);

        $manager->flush();

        $this->addReference(
            self::CATEGORY_QUINCAILLERIE,
            $quincaillerie );

        $this->addReference(
            self::CATEGORY_CUISINE,
            $cuisine );
    }
}
