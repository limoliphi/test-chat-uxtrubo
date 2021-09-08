<?php

namespace App\Controller;

use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagesController extends AbstractController
{
    /**
     * @Route("/rooms/{room}/messages/new", name="app_messages_new", methods={"GET", "POST"})
     */
    public function index(Room $room): Response
    {

        return $this->render('messages/new.html.twig', compact('room'));
    }
}