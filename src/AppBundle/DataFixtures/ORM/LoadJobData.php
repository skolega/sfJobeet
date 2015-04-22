<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Job;


class LoadJobData extends AbstractFixture implements OrderedFixtureInterface
{    
    public function getOrder()
    {
        return 3;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');
        
        for($j=0 ; $j < 500 ; $j++){
            $job = new Job();
            $job->setCompanyName($faker->company);
            $job->setDescription($faker->text(2000));
            $job->setHowToApply($faker->numberBetween($min = 1, $max = 3));
            $job->setLocation($faker->city);
            $job->setLogo('http://placehold.it/100x100');
            $job->setPublishedAt($faker->dateTimeThisMonth);
            $job->setPosition($faker->colorName);
            $job->setType($faker->numberBetween($min = 1, $max = 3));
            $job->setUrl($faker->url);
            $job->setCategory($this->getReference('category' .$faker->numberBetween(0, 19)));
            $job->setUser($this->getReference('user' .$faker->numberBetween(0, 21)));
            $job->setEmail($job->getUser()->getEmail());
            $job->setVerified($faker->boolean(90));
            $manager->persist($job);
        }
        
        $manager->flush();
        
    }
    

}
