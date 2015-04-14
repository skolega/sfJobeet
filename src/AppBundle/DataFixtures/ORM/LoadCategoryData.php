<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;


class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');
        
        for($j = 0; $j < 20; $j++){
            $category = new Category();
            $category->setName($faker->word);
            $category->setDescription($faker->text(200));
            $category->setEnabled(1);
            $manager->persist($category);
        }
        
        $manager->flush();
        
    }
    
    public function getOrder()
    {
        return 1;
    }
}

