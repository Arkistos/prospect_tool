<?php

namespace App\Service;

class CSVReader {

    public function readCSV(string $pathname):array
    {
        
        $csvAsArray = array_map('str_getcsv', file($pathname));

        $titles = $csvAsArray[0];

        $tableResult = [];

        foreach($csvAsArray as $key=>$line){
            $tab = [];
            foreach($line as $needle=>$element){
                $tab[$titles[$needle]] = $element;
            }
            array_push($tableResult, $tab);
        }


        return $tableResult;
    }
}