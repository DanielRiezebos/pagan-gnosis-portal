<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Setting;

class IntroTextFixture extends Fixture {
    public function load(ObjectManager $manager): void
    {
        $introTextSetting = new Setting();
        $introTextSetting->setSettingKey('intro_text');
        $introTextSetting->setSettingValue('Please insert intro text here.');

        $manager->persist($introTextSetting);

        $manager->flush();
    }
}