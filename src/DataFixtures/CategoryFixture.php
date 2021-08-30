<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for($i = 1 ; $i <= 5 ; $i++) {
        $category = new Category;
        $category -> setCatName("Category $i");
        $manager -> persist($category);
        }
        $manager->flush();
    }
}
