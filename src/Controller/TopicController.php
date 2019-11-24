<?php

namespace App\Controller;

use App\Entity\SubCategory;
use App\Entity\Topic;
use App\Entity\User;
use App\Form\TopicType;
use App\Repository\MessageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TopicController extends AbstractController
{
    /**
     * @var MessageRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(MessageRepository $repository, ObjectManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    public function index(PaginatorInterface $paginator, Request $request, Topic $topic, string $slug)
    {
        if ($topic->getSlug() !== $slug) {
            return $this->redirectToRoute('topic', [
                'id' => $topic->getId(),
                'slug' => $topic->getSlug(),
            ], 301);
        }

        $messages = $paginator->paginate(
            $this->repository->findByTopicQuery($topic),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('forum/topic.html.twig', [
            'topic' => $topic,
            'messages' => $messages,
            'current_menu' => 'home',
        ]);
    }

    public function new(SubCategory $subCategory, string $slug, Request $request)
    {
        if ($subCategory->getSlug() !== $slug) {
            return $this->redirectToRoute('subcategory', [
                'id' => $subCategory->getId(),
                'slug' => $subCategory->getSlug(),
            ], 301);
        }

        $user = null;
        if ($this->getUser() instanceof User) {
            $user = $this->getUser();
        }
        if (null === $user) {
            $this->addFlash('error', 'Vous devez être connecté pour ajouter un sujet.');
            return $this->redirectToRoute('subcategory', [
                'id' => $subCategory->getId(),
                'slug' => $subCategory->getSlug(),
            ], 301);
        }

        $topic = new Topic();
        $topic->setSubCategory($subCategory)
            ->setUser($user)
            ->setCreatedAt(new \DateTime('now'));
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
<<<<<<< HEAD
            $this->manager->persist($topic);
=======
>>>>>>> 84f10b5d59b15bcaf45015c9fed2102d2455e00d
            $this->manager->flush();
            $this->addFlash('success', 'Le topic a bien été ajouté.');

            return $this->redirectToRoute('subcategory', [
                'id' => $subCategory->getId(),
                'slug' => $subCategory->getSlug(),
            ]);
        }

        return $this->render('forum/topic.new.html.twig', [
            'topic' => $topic,
            'subcategory' => $subCategory,
            'form' => $form->createView(),
        ]);
    }
}
