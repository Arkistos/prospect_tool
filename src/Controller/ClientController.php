<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\CSVFormType;
use App\Service\CSVReader;
use App\Service\DataManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/clients/import', name: 'client_import')]
    public function clientImport(Request $request, DataManager $dataManager): Response
    {
        $csvForm = $this->createForm(CSVFormType::class);
        $csvForm->handleRequest($request);

        if($csvForm->isSubmitted() && $csvForm->isValid()){
            $pathname = $csvForm['csv']->getData()->getPathName();
            $data = (new CSVReader)->readCSV($pathname);
            $dataManager->storeData($data);
        }

        return $this->render('clients/import.html.twig', [
            'csvForm' => $csvForm,
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/clients/dashboard', name:'client_dashboard')]
    public function clientDashboard(EntityManagerInterface $entityManager):Response
    {

        $clients = $entityManager->getRepository(Client::class)->findAll();


        return $this->render('clients/dashboard.html.twig',[
            'clients' => $clients,
            'controller_name' => 'ClientController',
        ]);
    }
}

