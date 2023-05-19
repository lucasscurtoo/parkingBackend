<?php

    require_once "classes/connection/connection.php";
    require_once "classes/responses.class.php";

    $connection = new connection;
    $response = new responses;

    class parkingSpot extends connection{
        private $response;

        //cambiar el id a autoincrement

        public function __construct() {
            parent::__construct();
            $this->response = new responses();
          }

        public function getAllPLaces(){
            $allPlaces = $this->getData("select * from lugar");

            if (!$allPlaces){
                return $this->response->error_204("No places in the parking add new ones");
            }

            return $allPlaces;
        }

        public function getFreePLaces(){
            $freePlaces = $this->getData("select * from lugar where ocupado = 0");

            if (!$freePlaces){
                return $this->response->error_204("No free places in the parking :(");
            }

            return $freePlaces;
        }
        
        public function getOccupiedPlaces(){
            $occupied = $this->getData("select * from lugar where ocupado = 1");

            if (!$occupied){
                return $this->response->error_204("No occupied places in the parking :)");
            }

            return $occupied;
        }

        public function createNewParkingSpot($params){
            $values = "";
            foreach ($params as $key => $value) {
                $values .= "'" . $value . "',";
            }
            $values = rtrim($values, ",");

            $insertQuery = "INSERT INTO lugar VALUES ($values)";
            $newParkingSpot = $this->insertData($insertQuery);

            if (!$newParkingSpot) {
               return "Can't create a new parking spot";
            }

            return $this->response->success_200("Successfully created a new parking spot");
        }
      
    }

?>