<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * HomeController constructor.
     *
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
            'search' => '',
            'categories' => $categories,
        ]);
    }

    /**
     * @param PaginatorInterface $paginator
     * @param Request            $request
     * @param SubCategory        $subCategory
     * @param string             $slug
     * @param string             $search
     *
     * @return Response
     */
    public function search(PaginatorInterface $paginator, TopicRepository $topicRepository, Request $request, string $search): Response
    {
        $topics = $paginator->paginate(
            $topicRepository->findByNameQuery($search),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('pages/search.html.twig', [
            'topics' => $topics,
            'search' => $search,
            'current_menu' => 'home',
        ]);
    }
}
