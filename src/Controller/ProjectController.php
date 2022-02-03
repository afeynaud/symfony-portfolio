<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projet', name: 'project_')]
class ProjectController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function index(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $managerRegistry->getManager();
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('home_index');
        }
        return $this->renderForm('project/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Request $request, ManagerRegistry $managerRegistry, Project $project): Response
    {
        $entityManager = $managerRegistry->getManager();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('project_show', ['id' => $project->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/edit.html.twig', [
            'form' => $form->createView(),
            'project' => $project,
        ]);
    }

    #[Route('/{id}', name: 'delete')]
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager) : Response
    {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
            $this->addFlash('success','Votre Projet à bien été supprimé');
        }
        return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
    }
}
