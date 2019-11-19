<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Repository\MessageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TopicController extends AbstractController
{

    /**
     * @var MessageRepository
     */
    private $repository;

    public function __construct(MessageRepository $repository){
        $this->repository = $repository;
    }

    public function index(PaginatorInterface $paginator, Request $request, Topic $topic, string $slug)
    {
        if($topic->getSlug() !== $slug)
        {
            return $this->redirectToRoute("topic",[
                'id' => $topic->getId(),
                'slug' => $topic->getSlug()
            ],301);
        }

        $messages = $paginator->paginate(
            $this->repository->findByTopicQuery($topic),
            $request->query->getInt('page',1),
            10
        );

        return $this->render('forum/topic.html.twig', [
            'topic' => $topic,
            'messages' => $messages,
            'current_menu' => 'home'
        ]);
    }
}
