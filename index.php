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
    $result = $vehicles->getVehicles();
    $response = json_encode($result);
    header('Content-Type: application/json');
    return $response;
});

$klein->respond('GET', '/vehicles/[i:registration]', function ($request) use($vehicles) {
    $result = $vehicles->getVehicleByRegistration(intval($request->registration));
    $response = json_encode($result);
    header('Content-Type: application/json');
    return $response;
});

//parking spots

$klein->respond('GET', '/parkingSpots', function () use($parkingSpot) {
    $result = $parkingSpot->getAllPLaces();
    $response = json_encode($result);
    header('Content-Type: application/json');
    return $response;
});

$klein->respond('GET', '/parkingSpots/free', function () use($parkingSpot) {
    $result = $parkingSpot->getFreePLaces();
    $response = json_encode($result);
    header('Content-Type: application/json');
    return $response;
    
});

$klein->respond('GET', '/parkingSpots/occupied', function () use($parkingSpot) {
    $result = $parkingSpot->getOccupiedPlaces();
    $response = json_encode($result);
    header('Content-Type: application/json');
    return $response;
});

$klein->respond('POST', '/parkingSpots', function ($request) use($parkingSpot) {
    $body = $request->body();
    $result = $parkingSpot->createNewParkingSpot($body);
    $response = json_encode($result);
    header('Content-Type: application/json');
    return $response;
});

$klein->respond('PUT', '/parkingSpots/[i:id]', function ($request) use($parkingSpot) {
    $id = intval($request->id);
    $body = $request->body();
    $result = $parkingSpot->editParkingSpot($id,$body);
    $response = json_encode($result);
    header('Content-Type: application/json');
    return print_r($response);
});

$klein->respond('DELETE', '/parkingSpots/[i:id]', function ($request) use($parkingSpot) {
    $id = intval($request->id);
    $result = $parkingSpot->deleteParkingSpot($id);
    $response = json_encode($result);
    header('Content-Type: application/json');
    return print_r($response);
});

$klein->respond('POST', '/parkingSpots/takePlace', function ($request) use($parkingSpot) {
    $body = intval($request->body());
    $result = $parkingSpot->takeAPlace($body);
    $response = json_encode($result);
    header('Content-Type: application/json');
    return print_r($response);
});





$klein->dispatch();

?>