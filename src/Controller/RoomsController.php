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

        return $this->render('rooms/new.html.twig', compact('rooms'));
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

            return $this->redirectToRoute('app_rooms_show', ['id' => $room->getId()]);
        }

        return $this->render('rooms/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/rooms/{id<[0-9]+>}", name="app_rooms_show", methods="GET")
     */
    public function show(Room $room): Response
    {
        return $this->render('rooms/show.html.twig', compact('room'));
    }

    /**
     * @Route("/rooms/{id<[0-9]+>}/edit", name="app_rooms_edit", methods="GET|PUT")
     */
    public function edit(Room $room, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(RoomType::class, $room, [
            'method' => 'PUT'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash(
                'success','Room was successfully updated');

            return $this->redirectToRoute('app_rooms_show', ['id' => $room->getId()]);
        }

        return $this->render('rooms/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/rooms/{id<[0-9]+>}", name="app_rooms_delete", methods="DELETE")
     */
    public function delete(Room $room, EntityManagerInterface $em, Request $request): Response
    {
        if ($this->isCsrfTokenValid('rooms_deletion_' . $room->getId(), $request->request->get('csrf_token'))) {
            $em->remove($room);
            $em->flush();
        }

        $this->addFlash('success', 'Room was successfully deleted');

        return $this->redirectToRoute('app_rooms_index');

    }
}
