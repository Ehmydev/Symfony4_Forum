<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Category $category
     * @param string $slug
     * @return Response
     */
    public function index(Category $category, string $slug): Response
    {
        if ($category->getSlug() !== $slug) {
            return $this->redirectToRoute('category', [
                'id' => $category->getId(),
                'slug' => $category->getSlug(),
            ], 301);
        }

        return $this->render('forum/category.html.twig', [
            'category' => $category,
            'current_menu' => 'home',
        ]);
    }
}
