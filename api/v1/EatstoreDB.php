<?php 

class EatstoreDB {
    
   protected $mysqli;
   const LOCALHOST  = '127.0.0.1';
   const USER       = 'root';
   const PASSWORD   = '';
   const DATABASE   = 'eatstore';
   
   public function __construct() {           
      try {
         // Conexión a base de datos
         $this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
      } catch (mysqli_sql_exception $e) {
         // Si no se puede realizar la conexión
         http_response_code(500);
         exit;
      }     
   } 
   
   public function getPlato($id=0) {      
      $stmt = $this->mysqli->prepare("SELECT * FROM plato WHERE idplato=? ; ");
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $result = $stmt->get_result();        
      $plato = $result->fetch_all(MYSQLI_ASSOC); 
      $stmt->close();
      return $plato;              
   }
   
   public function getPlatos() {        
      $result = $this->mysqli->query('SELECT * FROM plato');          
      $platos = $result->fetch_all(MYSQLI_ASSOC);          
      $result->close();
      return $platos; 
   }
   
   public function insert($data) {
      $nombre = $data["nombre"];
      $foto = $data["foto"];
      $descripcion = $data["descripcion"];
      $idcategoria = $data["idcategoria"];
      $precio = $data["precio"];

      $stmt = $this->mysqli->prepare("INSERT INTO plato(nombre,foto,descripcion,idcategoria,precio) VALUES ('$nombre','$foto','$descripcion','$idcategoria','$precio'); ");
      $r = $stmt->execute(); 
      $id = mysqli_insert_id($this->mysqli);
      $stmt->close();
      return $id;        
   }

   public function insertImg($img, $id) {
      $stmt = $this->mysqli->prepare("UPDATE plato SET foto='$img' WHERE idplato=$id;");
      $r = $stmt->execute(); 
      $stmt->close();
      return $r;        
   }
   
   public function delete($id=0) {
      $stmt = $this->mysqli->prepare("DELETE FROM plato WHERE idplato = ? ; ");
      $stmt->bind_param('s', $id);
      $r = $stmt->execute(); 
      $stmt->close();
      return $r;
   }

   public function update($id, $data) {
      $nombre = $data["nombre"];
      $foto = $data["foto"];
      $descripcion = $data["descripcion"];
      $idcategoria = $data["idcategoria"];
      $precio = $data["precio"];

      if($this->checkID($id)) {
         $stmt = $this->mysqli->prepare("UPDATE plato SET nombre='$nombre', foto='$foto', descripcion='$descripcion', idcategoria='$idcategoria',precio='$precio' WHERE idplato = $id ; ");
         $r = $stmt->execute($data); 
         $id = mysqli_insert_id($this->mysqli);
         $stmt->close();
         return $id;    
      }            
      return false;
   }

   public function checkID($id) {
      $stmt = $this->mysqli->prepare("SELECT * FROM plato WHERE idplato=?");
      $stmt->bind_param("s", $id);
      if($stmt->execute()) {
         $stmt->store_result();    
         if ($stmt->num_rows == 1) {                
            return true;
         }
      }  
      return false;
   }
}
?>