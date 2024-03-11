<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class EmailGeneratorController extends AbstractController
{
    #[Route('/emailgenerator', name: 'app_email_generator')]
    public function emailGenerator(MailerInterface $mailer): Response
    {

        $email = (new Email())
            ->from('me@pierrelacaud.fr')
            ->to('pierre.lacaud@gmail.com')
            ->subject('Essai d\'email')
            ->text('Nouvel Email');

        $mailer->send($email);

        return $this->render('emailgenerator.html.twig');
    }
}
