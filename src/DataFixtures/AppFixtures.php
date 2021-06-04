<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $loader = new NativeLoader();

        $objectSet = $loader->loadFile(__DIR__ . '/fixtures.yaml');

        foreach ($objectSet->getObjects() as $object) {
            $manager->persist($object);
        }

        $manager->flush();
    }

}