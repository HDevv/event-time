<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

use App\Form\ConctactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Mime\Email;


class ConctactController extends AbstractController
{
    #[Route('/contactez-nous', name: 'app_conctact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $form = $this->createForm(ConctactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $email = (new TemplatedEmail())
                ->from($data['email'])
                ->to('noreply@example.com')
                ->subject('Demande de contact')
                ->htmlTemplate('email/contact.html.twig')
                ->context([
                    'emailFrom' => $data['email'],
                    'subject' => $data['subject'],
                    'message' => $data['message'],
                ]);

            $mailer->send($email);
        }

        return $this->render('conctact/index.html.twig', [
            'form' =>$form->createView(),
        ]);
    }
}
