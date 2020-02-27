<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\PrivateMessage;
use App\Form\ConversationType;
use App\Form\PrivateMessageType;
use App\Repository\ConversationRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/conversation")
 */
class ConversationController extends AbstractController
{
    /**
     * @Route("/", name="conversation_index", methods={"GET"})
     * @param ConversationRepository $conversationRepository
     * @return Response
     */
    public function index(ConversationRepository $conversationRepository): Response
    {
        return $this->render('conversation/index.html.twig', [
            'conversations' => $conversationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="conversation_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function new(Request $request): Response
    {
        $pm = new PrivateMessage();
        $pm->setAuthor($this->getUser())
            ->setIsRead(true)
            ->setPostedAt(new DateTime());
        $conversation = new Conversation();
        $conversation->setCreatedAt(new DateTime())
            ->setStarter($this->getUser())
            ->addPrivateMessage($pm);

        $form = $this->createForm(ConversationType::class, $conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conversation);
            $entityManager->flush();

            return $this->redirectToRoute('conversation_index');
        }

        return $this->render('conversation/new.html.twig', [
            'conversation' => $conversation,
            'form' => $form->createView(),
            'button_label' => 'Envoyer le message',
        ]);
    }

    /**
     * @Route("/{id}", name="conversation_show", methods={"GET", "POST"})
     * @param Conversation $conversation
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function show(Conversation $conversation, Request $request): Response
    {
        $pm = new PrivateMessage();
        $pm->setAuthor($this->getUser())
            ->setIsRead(true)
            ->setPostedAt(new DateTime())
            ->setConversation($conversation);
        $form = $this->createForm(PrivateMessageType::class, $pm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pm);
            $entityManager->flush();

            return $this->redirectToRoute('conversation_show', ['id' => $conversation->getId()]);
        }
        return $this->render('conversation/show.html.twig', [
            'conversation' => $conversation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="conversation_delete", methods={"DELETE"})
     * @param Request $request
     * @param Conversation $conversation
     * @return Response
     */
    public function delete(Request $request, Conversation $conversation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conversation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($conversation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('conversation_index');
    }
}
