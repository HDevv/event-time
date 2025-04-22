<?php

namespace App\Controller;

use App\Entity\Event;
use App\Service\EventService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class EventController extends AbstractController
{
    #[Route('/evenements', name: 'event_list')]
    #[Route('/events')]
    public function index(Environment $twig, EventService $eventService, ManagerRegistry $doctrine): Response
    {
        // $events = $eventService->all();
        $events = $doctrine->getRepository(Event::class)->findAll();

        // dump($eventService);

        // return new Response($twig->render('event/index.html.twig', [
        //     'events' => $events,
        // ])); 

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }


    #[Route('/evenements/{id}', name: 'event_show', requirements: ['id' => '\d+'])]
    public function show(EventService $eventService, ManagerRegistry $doctrine, Event $event): Response
    {
        // $event = $eventService->find($id);
        // $event = $doctrine->getRepository(Event::class)->find($id);

        dump($event);

        // if (! $event) {
        //     throw $this->createNotFoundException();
        // }

        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }


    #[Route('/evenements/creer', name: 'event_create')]
    public function create(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();

        $event = new Event();
        $event->setName('Vidéo');
        $event->setPrice(50);
        $event->setStartAt(new \DateTime('2025-04-21'));
        $event->setEndAt(new \DateTime('2025-10-22'));

        $em->persist($event);
        $em->flush();
        

        return $this->redirectToRoute('event_list');
    }
}
