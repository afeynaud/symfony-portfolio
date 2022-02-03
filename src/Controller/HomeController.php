<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $projects = $managerRegistry
            ->getRepository(Project::class)
            ->findAll();

        return $this->render('home/index.html.twig', [
            'projects' => $projects,
        ]);
    }
}
