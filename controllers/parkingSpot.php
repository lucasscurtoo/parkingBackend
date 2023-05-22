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
            $decodedParams = json_decode($params);

            if (empty($params)) {
                return $this->response->error_400();
              
            }
          
            if (isset($decodedParams->floor, $decodedParams->number)) {
                $floor = $decodedParams->floor;
                $number = $decodedParams->number;
                $occupied = 0;
            
                $insertQuery = "INSERT INTO lugar (piso, numero, ocupado) VALUES ('$floor', '$number', '$occupied')";
           
                $newParkingSpot = $this->insertData($insertQuery);
                
                if (!$newParkingSpot) {
                return "Can't create a new parking spot";
                }

                return $this->response->success_200("Successfully created a new parking spot");

            }else {
                return $this->response->error_400();
            }
        }

        //recive un objeto y verifica que tiene que editar
        public function editParkingSpot($id, $valueToEdit) {
            $decodedValue = json_decode($valueToEdit, true); // Set the second parameter to true for associative array conversion
            
            if (!$id) {
                return $this->response->error_400("No id provided");
            }
        
            if (!$valueToEdit) {
                return $this->response->error_400("No values provided");
            }
        
            $parkingSpot = $this->getData("select * from lugar where id_lugar = ".$id);
        
            $parkingSpotObject = json_decode(json_encode($parkingSpot[0]));

            foreach ($decodedValue as $propertyName => $propertyValue) {
                if (property_exists($parkingSpotObject, $propertyName)) {
                    $sqlQuery = "UPDATE lugar SET " . $propertyName . ' = ' . $propertyValue . " WHERE id_lugar = " . $id;
                    $updatedData = $this->updateData($sqlQuery);
                }
            }
            return $this->response->success_200("Successfully updated");
        }

        public function deleteParkingSpot($id){
            $parkingSpot = $this->getData("select * from lugar where id_lugar = ".$id);

            if (!$parkingSpot){
                return $this->response->error_404('Ivalid id provided');
            }
            $sqlQquery = "DELETE FROM lugar WHERE id_lugar =".$id;

            $deleteData = $this->deleteData($sqlQquery);

            if (!$deleteData) {
                return "could not delete";
            }
            return "Data deleted successfully";
        }

        public function takeAPlace($body){
           $decodedBody = json_decode($body);

            if (isset($decodedBody->vehicleRegistration, $decodedBody->parkingSpotId)) {
                $vehicleRegistration = $decodedBody->vehicleRegistration;
                $parkingSpotId = $decodedBody->parkingSpotId;
                
                $parkingSpot = $this->getData("select id_lugar from lugar where id_lugar = ".$parkingSpotId);
                $vehicle = $this->getData("select matricula from vehiculo where matricula = ".$vehicleRegistration);

                if (!$parkingSpot || !$vehicle) {
                   return $this->response->error_404("Ivalid vehicle registration or parking spot id");
                }

                $insertSql = "INSERT INTO ocupa VALUES ('$vehicleRegistration','$parkingSpotId')";

                $insert = $this->insertData($insertSql);
            }

            return $this->response->error_404("Invalid information provided");
            
        }
      
    }

?>