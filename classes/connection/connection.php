<?php
//hay que habilitar las extensiones mysqli, mbstring
class connection {

  private $server;
  private $user;
  private $password;
  private $database;
  private $port;
  private $connection; 

function __construct(){
    $dataArray = $this->connectionData();
    foreach ($dataArray as $key => $value) {
        $this-> server = $value['server'];     
        $this-> user = $value['user'];     
        $this-> password = $value['password'];
        $this-> database = $value['database'];
        $this-> port = $value['port']; 
    
    }
    
    $this->connection = new mysqli(
        $this->server,
        $this->user,
        $this->password,
        $this->database,
        $this->port
    ); 

    if ($this->connection->connect_errno) {
            echo "Somethings wrong with the connection";
            die();
    };
}

    private function connectionData(){
        $direction = dirname(__FILE__);
        $jsonData = file_get_contents($direction . "/" . "config");
        //convierte a un array
        return json_decode($jsonData, true);
    }

//convierte a utf-8 asi no tenemos problemas con caracteres especiales
private function convertToUTF8($array) {
    array_walk_recursive($array, function (&$item, $key) {
        if (!mb_check_encoding($item, 'UTF-8')) {
            $item = mb_convert_encoding($item, 'UTF-8');
        }
    });
    return $array;
}

    public function getData($query){
        $results = $this->connection->query($query);
        $resultsArray = array();
        foreach ($results as $key) {
            $resultsArray[] = $key; //push de key en el array
        }
        return $this->convertToUTF8($resultsArray);
    }

    //Esta función es útil para ejecutar consultas SQL que no devuelven
    //ningún dato, como INSERT, UPDATE y DELETE.
    public function insertData($query){
          //nos devuelve el id de la fila que guardamos
        $results = $this->connection->query($query);
        $rows =  $this->connection->affected_rows;
        if ($rows >= 1) {
            return $this->connection->insert_id;
        }else{
            return false;
        }
    }

    public function updateData($query){
        $results = $this->connection->query($query);

        if (!$results) {
            return false;
        }
        return $this->connection->affected_rows;
    }

    public function deleteData($query){
        $results = $this->connection->query($query);

        if (!$results) {
            return false;
        }
        return $this->connection->affected_rows;
    }
  
}
?>