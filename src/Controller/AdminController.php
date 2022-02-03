<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CodeLanguage;
use App\Entity\Project;
use App\Form\CategoryType;
use App\Form\CodeLanguageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $projects = $managerRegistry->getRepository(Project::class)->findAll();
        $categories = $managerRegistry->getRepository(Category::class)->findAll();
        $codeLanguages = $managerRegistry->getRepository(CodeLanguage::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'projects' => $projects,
            'categories' => $categories,
            'code_languages' => $codeLanguages,
        ]);
    }
    
    #[Route('/category/new', name: 'category_new')]
    public function newCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
    
    #[Route('/category/{id}/edit', name: 'category_edit')]
    public function editCategory(
        Request $request,
        Category $category,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
    
    #[Route('/category/{id}', name: 'category_delete')]
    public function deleteCategory(
        Request $request,
        Category $category,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/code-language/new', name: 'code_language_new')]
    public function newCodeLanguage(Request $request, EntityManagerInterface $entityManager): Response
    {
        $codeLanguage = new CodeLanguage();
        $form = $this->createForm(CodeLanguageType::class, $codeLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($codeLanguage);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/code_language/new.html.twig', [
            'code_language' => $codeLanguage,
            'form' => $form,
        ]);
    }

    #[Route('/code-language/{id}/edit', name: 'code_language_edit')]
    public function editCodeLanguage(
        Request $request,
        CodeLanguage $codeLanguage,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(CodeLanguageType::class, $codeLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/code_language/edit.html.twig', [
            'code_language' => $codeLanguage,
            'form' => $form,
        ]);
    }

    #[Route('/code-language/{id}', name: 'code_language_delete')]
    public function deleteCodeLanguage(
        Request $request,
        CodeLanguage $codeLanguage,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $codeLanguage->getId(), $request->request->get('_token'))) {
            $entityManager->remove($codeLanguage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
