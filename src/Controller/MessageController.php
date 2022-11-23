<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'message')]
    public function index(
        MessageRepository $repository
    ): Response {
        $messages = $repository->findAll();
        return $this->render('pages/message/index.html.twig', [
            'messages' => $messages
            // 'controller_name' => 'MessageController',
        ]);
    }

    #[Route('/message/nouveau', 'message.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            $manager->persist($message);
            $manager->flush();

            return $this->redirectToRoute('message');
        }

        return $this->render('pages/message/new.html.twig', [
            'form' => $form->createView()

        ]);
    }
    #[Route('/message/update/{id}', 'message.edit', methods: ['GET', 'POST'])]
    public function edit(
        Message $message,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();

            $manager->persist($message);
            $manager->flush();

            return $this->redirectToRoute('message');
        }
        // $form = $this->createForm(MessageType::class, $message);

        return $this->render('pages/message/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
