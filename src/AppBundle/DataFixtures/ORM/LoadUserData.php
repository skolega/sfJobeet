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

        $superAdmin = new User;
        $superAdmin->setUsername('admin');
        $superAdmin->setEmail('admin@admin.pl');
        $superAdmin->setPlainPassword('admin');
        $superAdmin->setEnabled(true);
        $superAdmin->setRoles(array('ROLE_SUPER_ADMIN'));
        $superAdmin->setVerified(true);

        $manager->persist($superAdmin);

        $admin = new User;
        $admin->setUsername('user');
        $admin->setEmail('user@user.pl');
        $admin->setPlainPassword('user');
        $admin->setEnabled(true);
        $admin->setRoles(array('ROLE_REGISTERED'));
        $admin->setVerified(true);

        $manager->persist($admin);

        for ($i = 0; $i < 20; $i++) {
            $user = new User;
            $user->setUsername($faker->username);
            $user->setEmail($faker->email);
            $user->setPlainPassword($faker->word);
            $user->setEnabled(false);
            $user->setRoles(array('ROLE_ADMIN'));
            
            $manager->persist($user);
        }
        
        $manager->flush();

    }
}
