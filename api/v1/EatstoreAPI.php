<?php

require_once('EatstoreDB.php');

// Permitir desde cualquier origen
if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $origin = $_SERVER['HTTP_ORIGIN'];
} else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
    $origin = $_SERVER['HTTP_REFERER'];
} else {
    $origin = $_SERVER['REMOTE_ADDR'];
}

header("Access-Control-Allow-Origin: {$origin}");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST,PUT,DELETE,OPTIONS");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

class EatstoreAPI {    
    
    public function API() {
        header('Content-Type: application/JSON');                
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET': // consulta
                $this->getPlatos();
                break;     
            case 'POST': // inserta
                $this->addPlato();
                break;                
            case 'PUT': // actualiza
                $this->updatePlato();       
                break;      
            case 'DELETE': // elimina
                $this->deletePlato();
                break;
            default: // metodo NO soportado
                echo 'METODO NO SOPORTADO';
                break;
        }
    }   

    /**
     * Respuesta al cliente
     * @param int $code Codigo de respuesta HTTP
     * @param String $status indica el estado de la respuesta puede ser "success" o "error"
     * @param String $message Descripcion de lo ocurrido
     */
    function response($code=200, $status="", $message="") {
        http_response_code($code);
        if( !empty($status) && !empty($message) ) {
            $response = array("status" => $status ,"message"=>$message);  
            echo json_encode($response,JSON_PRETTY_PRINT);    
            } 
    }

    /**
     * función que segun el valor de "action" e "id":
     *  - mostrara una array con todos los registros de personas
     *  - mostrara un solo registro 
     *  - mostrara un array vacio
     */
    function getPlatos() {
        if($_GET['action'] == 'platos')  {
            $db = new EatstoreDB();
            if(isset($_GET['id'])) {
                // muestra 1 solo registro si es que existiera ID                 
                $response = $db->getPlato($_GET['id']);   //Consultas con mysqli  
                echo json_encode($response,JSON_PRETTY_PRINT);
            } else { //muestra todos los registros                   
                $response = $db->getPlatos();   //consultas con mysqli
                echo json_encode($response,JSON_PRETTY_PRINT);
            }
        } else {
            $this->response(400);
        }       
    }  

    /**
     * metodo para guardar un nuevo registro de persona en la base de datos
    */
    function addPlato() {
        if($_GET['action']=='platos'){
            if(isset($_GET['id'])){
                //anadir imagen
                $obj = json_decode( file_get_contents('php://input') ); 
                print_r($_POST);
                
                //print_r(file_get_contents('php://input')) ;
                $obj2 = getimagesizefromstring(file_get_contents('php://input'),$info);
                // print_r($obj2);
                // print_r($info);
                $objArr = (array)$obj;
                if (empty($objArr)) {
                    $this->response(422,"error","Nothing to add. Check json");                           
                } else if(isset($obj->foto)) {
                    $db = new EatstoreDB();     
                    $db->insertImg( $obj->foto, $_GET['id']);
                    $this->response(200,"success","img added");                             
                } else {
                    $this->response(422,"error","The property is not defined");
                }
            }else{
                //anadir plato
                //Decodifica un string de JSON
                $obj = json_decode( file_get_contents('php://input') );   
                $objArr = (array)$obj;
                if (empty($objArr)) {
                    $this->response(422,"error","Nothing to add. Check json");                           
                } else if(isset($obj->nombre)) {
                    $db = new EatstoreDB();     
                    $respuesta=$db->insert($objArr);
                    $this->response(200,"Último id",$respuesta);                             
                } else {
                    $this->response(422,"error","The property is not defined");
                }
            }
        } else {               
                $this->response(400);
            }  
        }

    /**
     * Actualiza un recurso
     */
    function updatePlato() {
        if( isset($_GET['action']) && isset($_GET['id']) ) {
            if($_GET['action']=='platos') {
                $obj = json_decode( file_get_contents('php://input') );   
                $objArr = (array)$obj;
                if (empty($objArr)) {                        
                    $this->response(422,"error","Nothing to add. Check json");                        
                } else if(isset($obj->name)) {
                    $db = new EatstoreDB();
                    $respuesta=$db->update($_GET['id'], $obj->name);
                    $this->response(200,"success","Last id ".$respuesta);                             
                } else {
                    $this->response(422,"error","The property is not defined");                        
                }     
                exit;
            }
        }
        $this->response(400);
    }

    /**
     * elimina plato
     */
    function deletePlato() {
        if( isset($_GET['action']) && isset($_GET['id']) )  {
            if($_GET['action']=='platos') {                   
                $db = new EatstoreDB();
                $db->delete($_GET['id']);
                $this->response(204);                   
                exit;
            }
        }
        $this->response(400);
    }

}
//end class
?>