<?php

    require_once "classes/connection/connection.php";
    require_once "classes/responses.class.php";

    $connection = new connection;
    $response = new responses;

    class vehicles extends Connection{
      private $response;
     
      public function __construct() {
        parent::__construct();
        $this->response = new responses();
      }

      public function getVehicles(){
            $vehicles = $this->getData("select * from vehiculos");
            return $vehicles;
        }

        public function getVehicleByRegistration($registration){
            $vehicle = $this->getData("select * from vehiculos where matricula =".$registration);
            if (!$vehicle) {
                return $this->response->error_400("Invalid registration");
              }
            return $vehicle;
        }
        
        // public function getVehicleParkingSpot($registration) {
        //     $vehicleParkingSpot = $this->getData("select * from ocupa where matricula =".$registration);
        
        //     if (!$vehicleParkingSpot) {
        //       return $this->response->error_400("Invalid registration");
        //     }
        //     return $vehicleParkingSpot;
        //   }
    }

?>