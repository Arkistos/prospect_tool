<?php

namespace App\Service;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;

class DataManager
{
    private ?EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    public function storeData(array $data):bool{
        foreach($data as $key=>$client){
            if(!$this->clientIsTitle($client) && !$this->clientIsEmpty($client)){

                $newClient = new Client();
                $newClient->setCompanyName($client['name']);
                $newClient->setWebsite($client['website']);
                $newClient->setEmail($client['emails']);
                $newClient->setPhone($client['phone_number']);
                
                $this->entityManager->persist($newClient);
                $this->entityManager->flush();

            }
        }
        return true;
    }

    private function clientIsTitle(array $client):bool{
        $result = 0;
        foreach($client as $key=>$information){
           if($key == $information){
            $result++;
           }
        }
        return $result==6;
    }

    private function clientIsEmpty(array $client):bool{
        $result = 0;
        foreach($client as $information){
           if('' == $information){
            $result++;
           }
        }
        return $result==6;
    }


}