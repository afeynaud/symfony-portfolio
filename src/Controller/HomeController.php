<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectFilterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $projects = $managerRegistry
            ->getRepository(Project::class)
            ->findAll();
        $form = $this->createForm(ProjectFilterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $filters = $request->request->get('filter');
            $projectRepository = $managerRegistry->getRepository(Project::class);
            $projects = $projectRepository->findWithFilters($filters);
        }

        return $this->renderForm('home/index.html.twig', [
            'projects' => $projects,
            'form' => $form,
        ]);
    }
}
