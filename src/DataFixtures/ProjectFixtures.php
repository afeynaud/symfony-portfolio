<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Cassandra\Date;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class ProjectFixtures extends Fixture
{
    public const PROJECTS = [
        [
            'title' => 'Portfolio Vue JS',
            'description' => 'Réalisation d\'un portfolio en Vue JS avec le framework Gridsome pour mon apprentissage 
            personnel. Mise en place d\'un blog avec GraphQL.',
            'showcaseImage' => 'https://cdnb.artstation.com/p/assets/images/images/045/918/863/large/jordan-grimmer-fbdavyrwuailt3o-1.jpg?1643846335',
            'projectDate' => '2020-06-02',
            'applicationUrl' => 'https://alexandrefeynaud.com',
            'githubUrl' => 'https://github.com/afeynaud/site-afeynaud',
            'category' => 'Développement web',
            'codeLanguages' => ['PHP','JS','Vue'],
        ],
        [
            'title' => 'Best-Games.fr',
            'description' => 'Réalisation d\'un site de jeux flash sous Wordpress et MyArcadePlugin suite à mon 
            expérience chez ConcoursMania dans le but d\'apprendre à créer des sites internet sous Wordpress.',
            'showcaseImage' => 'https://cdna.artstation.com/p/assets/images/images/045/918/874/large/jordan-grimmer-fdb89iyxmamkple-1.jpg?1643846354',
            'projectDate' => '2020-06-02',
            'applicationUrl' => null,
            'githubUrl' => 'https://github.com/afeynaud/site-afeynaud',
            'category' => 'Développement web',
            'codeLanguages' => ['PHP','JS','Vue'],
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $projects = self::PROJECTS;

        foreach ($projects as $index => $projectData) {
            $project = new Project();

            $project
                ->setTitle($projectData['title'])
                ->setDescription($projectData['description'])
                ->setShowcaseImage($projectData['showcaseImage'])
                ->setProjectDate(new DateTime($projectData['projectDate']))
                ->setApplicationUrl($projectData['applicationUrl'])
                ->setGithubUrl($projectData['githubUrl'])
                ->setCategory($this->getReference('category_' . 0))
                ->addCodeLanguage($this->getReference('codeLanguage_' . 0))
                ->addCodeLanguage($this->getReference('codeLanguage_' . 1))
                ->setCreatedAt(new DateTime('now'));
            $manager->persist($project);
        }
        $manager->flush();
    }
}