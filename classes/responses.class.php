<?php

class responses{
    private $response = [
        'status' => "ok",
        'result' => array()
    ];

    public function success_200($string = "Successful request"){
        $this->response['status'] = 'ok';
        $this->response['result'] = array(
            "error_id" => "200",
            "error_message" => $string
        );
        return $this->response;
    }

    public function error_405(){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "error_id" => "405",
            "error_message" => "Method Not Allowed"
        );
        return $this->response;
    }

    public function error_200($string = "Incorrect Data"){//parametro opcional
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "error_id" => "200",
            "error_message" => $string
        );
        return $this->response;
    }

    public function error_204($string = "No Data"){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "error_id" => "200",
            "error_message" => $string
        );
        return $this->response;
    }

    public function error_400($string = "Incorrect Data"){//parametro opcional
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "error_id" => "400",
            "error_message" => "Data sended incorrectly"
        );
        return $this->response;
    }



}

?>