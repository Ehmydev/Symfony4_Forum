<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * HomeController constructor.
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): Response
    {
        $categories = $this->repository->findAllWithSubcategoryTopicMessage();

        return $this->render('pages/home.html.twig', [
            'current_menu' => 'home',
            'categories' => $categories,
        ]);
    }
}
