<?php

namespace App\Controller;

use App\Form\CSVFormType;
use App\Service\CSVReader;
use App\Service\DataManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/clients/import', name: 'client_import')]
    public function cilentImport(Request $request, DataManager $dataManager): Response
    {

        $csvForm = $this->createForm(CSVFormType::class);

        $csvForm->handleRequest($request);


        if($csvForm->isSubmitted() && $csvForm->isValid()){
            $pathname = $csvForm['csv']->getData()->getPathName();
            $data = (new CSVReader)->readCSV($pathname);

            $import = $dataManager->storeData($data);

            
        }


        return $this->render('clients/import.html.twig', [
            'csvForm' => $csvForm,
            'controller_name' => 'ClientController',
        ]);
    }
}
