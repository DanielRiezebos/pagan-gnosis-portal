<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Setting;

class AdminEmailFixture extends Fixture {
    public function load(ObjectManager $manager): void
    {
        $introTextSetting = new Setting();
        $introTextSetting->setSettingKey('admin_email');
        $introTextSetting->setSettingValue($_ENV['SUPER_ADMIN_EMAIL'] ?? 'superadmin@pagangnosisportal.test');

        $manager->persist($introTextSetting);

        $manager->flush();
    }
}