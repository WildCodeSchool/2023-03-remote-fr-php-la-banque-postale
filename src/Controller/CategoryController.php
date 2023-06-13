<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/categorie')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('{categoryTitle}', name: 'category_show')]
    public function show(string $categoryTitle, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['title' => $categoryTitle]);
        if (!$category) {
            throw $this->createNotFoundException('The category does not exist');
        }
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
