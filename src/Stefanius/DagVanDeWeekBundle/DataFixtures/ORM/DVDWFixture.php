<?php

namespace Stefanius\DagVanDeWeekBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures\Parser\Methods\Yaml;
use Nelmio\Alice\Persister\Doctrine;
use Symfony\Component\Finder\Finder;

class DVDWFixture extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $loader   = new Yaml();
        $finder   = new Finder();
        $fixtures = $finder
            ->in(__DIR__ . '/../../Resources/fixtures/')
            ->files()
            ->name('*.yml')
            ->sortByName()
        ;

        foreach ($fixtures as $file) {
            $objects = $loader->load($file);

            $this->loadObjects($manager, $objects);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param $objects
     */
    protected function loadObjects(ObjectManager $manager, $objects)
    {
        $persister = new Doctrine($manager);
        $persister->persist($objects);
    }
}
