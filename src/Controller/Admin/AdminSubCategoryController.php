<?php

namespace App\Controller\Admin;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminSubCategoryController extends AbstractController
{

    /**
     * @var SubCategoryRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository, SubCategoryRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $categories = $this->categoryRepository->findAll();
        $subcategories = $this->repository->findAll();
        return $this->render('admin/subcategory/index.html.twig',[
            'categories' => $categories,
            'subcategories' => $subcategories,
            'current_menu' => 'adminsubcat'
        ]);
    }

    /**
     * @param SubCategory $subcategory
     * @param Request $request
     * @return Response
     */
    public function edit(SubCategory $subcategory, Request $request): Response
    {
        $form = $this->createForm(SubCategoryType::class,$subcategory);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success','La sous-catégorie a bien été modifiée.');
            return $this->redirectToRoute('admin.subcategory.index');
        }
        return $this->render('admin/subcategory/edit.html.twig',[
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $subcategory = new SubCategory();
        $form = $this->createForm(SubCategoryType::class,$subcategory);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($subcategory);
            $this->em->flush();
            $this->addFlash('success','La sous-catégorie a bien été ajoutée.');
            return $this->redirectToRoute('admin.subcategory.index');
        }
        return $this->render('admin/subcategory/add.html.twig',[
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param SubCategory $subcategory
     * @param Request $request
     * @return Response
     */
    public function delete(SubCategory $subcategory, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete'.$subcategory->getId(), $request->get('_token'))){
            $this->em->remove($subcategory);
            $this->em->flush();
            $this->addFlash('success','La sous-catégorie a bien été supprimée.');
        }
        return $this->redirectToRoute('admin.subcategory.index');
    }

}