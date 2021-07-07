<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomsController extends AbstractController
{
    /**
     * @Route("/rooms", name="app_rooms_index", methods="GET")
     */
    public function index(RoomRepository $roomRepository): Response
    {
        $rooms = $roomRepository->findAll();

        return $this->render('rooms/index.html.twig', compact('rooms'));
    }

    /**
     * @Route("/rooms/new", name="app_rooms_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $room = new Room;
        $form = $this->createForm(RoomType::class, $room);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($room);
            $em->flush();

            $this->addFlash(
                'success','Room was successfully created');

            return $this->redirectToRoute('app_rooms_index');
        }

        return $this->render('rooms/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
