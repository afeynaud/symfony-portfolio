<?php

namespace App\DataFixtures;

use App\Entity\CodeLanguage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CodeLanguageFixtures extends Fixture
{
    public const CODE_LANGUAGES = [
        'PHP',
        'JS',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CODE_LANGUAGES as $key => $codeLanguageName) {
            $codeLanguage = new CodeLanguage();
            $codeLanguage->setName($codeLanguageName);
            $manager->persist($codeLanguage);
            $this->addReference('codeLanguage_' . $key, $codeLanguage);
        }
        $manager->flush();
    }
}
