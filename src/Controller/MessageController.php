<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'message')]
    public function index(
        MessageRepository $repository
    ): Response
    {
        $messages = $repository->findAll();
        return $this->render('pages/message/index.html.twig',[
            'messages' => $messages
            // 'controller_name' => 'MessageController',
        ]);
    }
}