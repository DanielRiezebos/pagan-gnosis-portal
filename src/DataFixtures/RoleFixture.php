<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Role;

class RoleFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $adminRole = new Role();
        $adminRole->setTitle(Role::RoleAdministrator);
        $adminRole->setDescription('Administrator role can manipulate settings, manage projects and manage users.');
        $manager->persist($adminRole);

        $userRole = new Role();
        $userRole->setTitle(Role::RoleUser);
        $userRole->setDescription('Users are allowed to participate and comment on GnosisProjects.');
        $manager->persist($userRole);

        $manager->flush();
    }
}
