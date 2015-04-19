<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\User;

/**
 * Description of LoadUserData
 *
 * @author adam
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');

        $admin = new User;
        $admin->setUsername('admin');
        $admin->setEmail('admin@admin.pl');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setVerified(true);

        $manager->persist($admin);


        for ($i = 0; $i < 20; $i++) {
            $user = new User;
            $user->setUsername($faker->username);
            $user->setEmail($faker->email);
            $user->setPlainPassword($faker->word);
            $user->setEnabled(false);
            $user->setRoles(array('ROLE_USER'));
            
            $manager->persist($user);
        }
        
        $manager->flush();

    }
}
