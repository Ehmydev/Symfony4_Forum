<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Reaction;
use App\Repository\ReactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReactionController extends AbstractController
{
    /**
     * @Route("/reaction", name="reaction")
     * @param Request $request
     * @param ReactionRepository $reactionRepository
     * @return JsonResponse|Response
     */
    public function index(Request $request, ReactionRepository $reactionRepository)
    {
        if ($request->isXMLHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            $messageRepository = $this->getDoctrine()->getRepository(Message::class);
            $message = $messageRepository->find($request->get('idMessage'));
            $type = $request->get('type');
            if (is_null($message) || is_null($user) || is_null($type)) {
                return new Response(
                    "Erreur: Le message ou l'utilisateur n'est pas bon", 400
                );
            } else {
                $reaction = $reactionRepository->findByMessageAndUser($message, $user);

                if (empty($reaction)) {
                    $reaction = new Reaction();
                    $reaction
                            ->setUser($user)
                            ->setMessage($message)
                            ->setType($type);
                    $entityManager->persist($reaction);
                } else {
                    $reaction = $reaction[0];
                    if ($reaction->getType() == boolval($type)) {
                        $entityManager->remove($reaction);
                    } else {
                        $reaction->setType($type);
                    }
                }
                $entityManager->flush();

                return new JsonResponse(['numberDislikes' => count($reactionRepository->findByMessageAndType($message, false)), 'numberLikes' => count($reactionRepository->findByMessageAndType($message, true))]);
            }
        }

        return new Response(
            'Erreur Inconnue', 400
        );
    }
}
