<?php

namespace App\Controller;

use App\Entity\SubCategory;
use App\Repository\TopicRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubCategoryController extends AbstractController
{
    /**
     * @var TopicRepository
     */
    private $topicRepository;

    /**
     * SubCategoryController constructor.
     *
     * @param TopicRepository $topicRepository
     */
    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }

    /**
     * @param PaginatorInterface $paginator
     * @param Request            $request
     * @param SubCategory        $subCategory
     * @param string             $slug
     *
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request, SubCategory $subCategory, string $slug): Response
    {
        if ($subCategory->getSlug() !== $slug) {
            return $this->redirectToRoute('subcategory', [
                'id' => $subCategory->getId(),
                'slug' => $subCategory->getSlug(),
            ], 301);
        }

        $topics = $paginator->paginate(
            $this->topicRepository->findBySubCategoryQuery($subCategory),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('forum/subcategory.html.twig', [
            'subcategory' => $subCategory,
            'topics' => $topics,
            'search' => '',
            'current_menu' => 'home',
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
    public function search(PaginatorInterface $paginator, Request $request, SubCategory $subCategory, string $slug, string $search): Response
    {
        if ($subCategory->getSlug() !== $slug) {
            return $this->redirectToRoute('subcategory', [
                'id' => $subCategory->getId(),
                'slug' => $subCategory->getSlug(),
            ], 301);
        }

        $topics = $paginator->paginate(
            $this->topicRepository->findBySubCategoryQuery($subCategory, $search),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('forum/subcategory.html.twig', [
            'subcategory' => $subCategory,
            'topics' => $topics,
            'search' => $search,
            'current_menu' => 'home',
        ]);
    }
}
