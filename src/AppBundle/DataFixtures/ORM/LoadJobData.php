<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Job;


class LoadJobData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');
        
        for($j=0 ; $j < 500 ; $j++){
            $job = new Job();
            $job->setCompanyName($faker->company);
            $job->setDescription($faker->text(400));
            $job->setEmail($faker->email);
            $job->setHowToApply($faker->text(100));
            $job->setLocation($faker->city);
            $job->setLogo('http://dummyimage.com/100/000/fff');
            $job->setPublishedAt($faker->dateTimeThisMonth);
            $job->setPosition($faker->word);
            $job->setType($faker->numberBetween($min = 1, $max = 25));
            $job->setUrl($faker->url);
            $manager->persist($job);
        }
        
        $manager->flush();
        
    }
    
    public function getOrder()
    {
        2;
    }
}
