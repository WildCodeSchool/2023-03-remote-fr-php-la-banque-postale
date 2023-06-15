<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\SearchType;
use App\Model\SearchData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\TutorialRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/categorie')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index_category')]
    public function index(
        CategoryRepository $categoryRepository,
        TutorialRepository $tutorialRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $categories = $categoryRepository->findAll();
        $tutorials = $tutorialRepository->findAll();

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchData->page = $request->query->getInt('page', 1);
            $queryBuilder = $tutorialRepository->findBySearch($searchData);

            $pagination = $paginator->paginate(
                $queryBuilder,
                $searchData->page,
                12 // Number of items per page
            );

            return $this->render('tutorial/searchtutorials.html.twig', [
                'form' => $form->createView(),
                'pagination' => $pagination,
                'tutorials' => $tutorials,
            ]);
        }

        return $this->render('category/index.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
        ]);
    }
    #[Route('/{slug}', name: 'category_show')]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
