<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmailGeneratorController extends AbstractController
{
    #[Route('/emailgenerator', name: 'app_email_generator')]
    public function index(): Response
    {
        return $this->render('emailgenerator.html.twig');
    }
}
