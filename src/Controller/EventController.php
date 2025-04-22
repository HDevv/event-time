<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Service\EventService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



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
    public function show(int $id, ManagerRegistry $doctrine): Response
    {
        $event = $doctrine->getRepository(Event::class)->find($id);

        if (! $event) {
            throw $this->createNotFoundException("Événement non trouvé");
        }

        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }



    #[Route('/evenements/creer', name: 'event_create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {

        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dump($event);
            $em = $doctrine->getManager();

            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute(('event_list'));
        }


        return $this->render('event/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
