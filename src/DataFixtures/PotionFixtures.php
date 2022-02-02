<?php

namespace App\DataFixtures;

use App\Entity\PotionType;
use App\Constants\Constant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PotionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Créer un type de potion activé
        $potionType = new PotionType();

        $potionType
            ->setName('soin')
            ->setImage('default')
            ->setStatus(Constant::STATUS_ACTIVATED);

        $manager->persist($potionType);

        // Créer un type de potion désactivé
        $potionTypeDisabled = new PotionType();

        $potionTypeDisabled
            ->setName('poison')
            ->setImage('default')
            ->setStatus(Constant::STATUS_DISABLED);

        $manager->persist($potionTypeDisabled);

        // Envoie les données en base de données
        $manager->flush();
    }
}
