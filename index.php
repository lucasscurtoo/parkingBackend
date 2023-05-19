<?php
require_once 'controllers/vehicles.php';
require_once 'controllers/parkingSpot.php';
require_once "classes/responses.class.php";
require_once('vendor/autoload.php');


$vehicles = new vehicles;
$parkingSpot = new parkingSpot;

$klein = new \Klein\Klein();


//vehicles

$klein->respond('GET', '/vehicles', function () use($vehicles) {
    return print_r($vehicles->getVehicles());
});

$klein->respond('GET', '/vehicles/[i:registration]', function ($request) use($vehicles) {
    return print_r($vehicles->getVehicleByRegistration(intval($request->registration)));
});

//parking spots

$klein->respond('GET', '/parkingSpots', function () use($parkingSpot) {
    return print_r($parkingSpot->getAllPLaces());
});

$klein->respond('GET', '/parkingSpots/free', function () use($parkingSpot) {
    return print_r($parkingSpot->getFreePLaces());
});

$klein->respond('GET', '/parkingSpots/occupied', function () use($parkingSpot) {
    return print_r($parkingSpot->getOccupiedPlaces());
});






$klein->dispatch();

//vehicles endpoints
// $router->map('GET', '/vehicles', print_r($vehicles->getVehicles()));
// $router->map('GET', '/vehicles/[i:id]', print_r($id));


// $router->map('GET', '/vehicles', function() {
//     return print_r($this->getVehicles());
// })

?>