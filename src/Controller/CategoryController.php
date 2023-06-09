<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Model\SearchData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;


#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index_category')]
    public function index(CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $categories = $categoryRepository->findAll();

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $searchData->page = $request->query->getInt('page', 1);
            $pagination = $categoryRepository->findBySearch($searchData);
        
            return $this->render('category/index.html.twig', [
                'form' => $form->createView(),
                'pagination' => $pagination,
                'categories' => $categories,
            ]);
        }

        return $this->render('category/index.html.twig', [         
            'form' => $form->createView(),
            'categories' => $categories,
        ]);
    }
}


    
    

