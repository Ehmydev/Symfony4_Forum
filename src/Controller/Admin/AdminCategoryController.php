<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCategoryController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * AdminCategoryController constructor.
     *
     * @param CategoryRepository $repository
     * @param EntityManagerInterface      $em
     */
    public function __construct(CategoryRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $categories = $this->repository->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories,
            'current_menu' => 'admincat',
        ]);
    }

    /**
     * @param Category $category
     * @param Request  $request
     *
     * @return Response
     */
    public function edit(Category $category, Request $request): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'La catégorie a bien été modifiée.');

            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function add(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($category);
            $this->em->flush();
            $this->addFlash('success', 'La catégorie a bien été ajoutée.');

            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render('admin/category/add.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Category $category
     * @param Request  $request
     *
     * @return Response
     */
    public function delete(Category $category, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->get('_token'))) {
            $this->em->remove($category);
            $this->em->flush();
            $this->addFlash('success', 'La catégorie a bien été supprimée.');
        }

        return $this->redirectToRoute('admin.category.index');
    }
}
