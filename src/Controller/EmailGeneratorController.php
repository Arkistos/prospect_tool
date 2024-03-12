<?php

namespace App\Controller;

use App\Form\EmailFormType;
use App\Service\CSVReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class EmailGeneratorController extends AbstractController
{
    #[Route('/emailgenerator', name: 'app_email_generator')]
    public function emailGenerator(MailerInterface $mailer, Request $request): Response
    {

        

        $form = $this->createForm(EmailFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $tmpName = $form['csv']->getData()->getPathName();

            $informations = (new CSVReader)->readCSV($tmpName);

            //dd($csvAsArray[4]['emails']);
            


            

            foreach($informations as $information){
                /*
                $email = (new Email())
                    ->from('me@pierrelacaud.fr')
                    ->to($information['email'])
                    ->subject($form->getData()['object'])
                    ->text($form->getData()['message']);

                $mailer->send($email);*/

            }
        }
        

        return $this->render('emailgenerator.html.twig', [
            'form' => $form
        ]);
    }
}
