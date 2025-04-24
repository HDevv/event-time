<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Service\EventService;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;


use Twig\Environment;

class EventController extends AbstractController
{
    #[Route('/evenements', name: 'event_list')]
    #[Route('/events')]
    public function index(Request $request, Environment $twig, EventService $eventService, ManagerRegistry $doctrine): Response
    {

         // Manipuler la REQ
        // dump($request->query->get('search'));
        dump($request->get('search'));

        // $events = $eventService->all();
        $query = $request->get('search');
        $events = $doctrine->getRepository(Event::class)->search($query);

        // dump($eventService);

        // return new Response($twig->render('event/index.html.twig', [
        //     'events' => $events,
        // ])); 

       
        

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }


    #[Route('/evenements/{id}', name: 'event_show', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_USER')]
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
    #[IsGranted('ROLE_ADMIN')]

    public function create(Request $request, ManagerRegistry $doctrine): Response
    {

        $event = new Event();
        $form = $this->createForm(EventType::class, $event, [
            'validation_groups' => ['Default', 'create']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dump($event);
            if ($file = $event->getPosterFile()) {
                $filename = md5(uniqid()).'.'.$file->guessExtension();
                $file->move('./images/events', $filename);

                $event->setPoster($filename);
            }
            $em = $doctrine->getManager();

            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'L\'événement '.$event->getName().' a bien été créé');

            return $this->redirectToRoute(('event_list'));
        }


        return $this->render('event/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/evenements/{id}/modifier', name: 'event_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Event $event, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($file = $event->getPosterFile()) {
                // SI img existe, on la suprrime pour uploader la nouvelle 
                if($poster = $event->getPoster()) {
                    @unlink('./images/events/' . $poster);
                }


                $filename = md5(uniqid()).'.'.$file->guessExtension();
                $file->move('./images/events', $filename);

                $event->setPoster($filename);
            }
            $em = $doctrine->getManager();
            $em->flush();

            $this->addFlash('success', 'L\'événement '.$event->getName().' a bien été modifié');


            return $this->redirectToRoute('event_list');
        }

        return $this->render('event/edit.html.twig', [
            'form' => $form->createView(),
            'event' => $event,
        ]);
    }

    #[Route('/evenements/{id}/supprimer', name: 'event_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, ManagerRegistry $doctrine, Event $event): Response
    {
        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $event->getId(), $submittedToken)) {
            if($poster = $event->getPoster()) {
                @unlink('./images/events/' . $poster);
            }
            $em = $doctrine->getManager();
            $em->remove($event);
            $em->flush();

            $this->addFlash('success', 'L\'événement '.$event->getName().' a bien été supprimé');

        }

        return $this->redirectToRoute('event_list');
    }
}
