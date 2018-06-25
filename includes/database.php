<?php
require_once("config.php");

class MySqli_DB {

    private $con;
    public $query_id;

    function __construct() {
      $this->db_connect();
    }

/*--------------------------------------------------------------*/
/* FUNCION QUE ABRE UNA CONEXION A LA BASE DE DATOS
/*--------------------------------------------------------------*/
public function db_connect()
{
  $this->con = mysqli_connect(DB_HOST,DB_USER,DB_PASS);
  if(!$this->con)
         {
           die(" Database connection failed:". mysqli_connect_error());
         } else {
           $select_db = $this->con->select_db(DB_NAME);
             if(!$select_db)
             {
               die("Failed to Select Database". mysqli_connect_error());
             }
         }
}
/*--------------------------------------------------------------*/
/* FUNCION QUE CIERRA LA CONEXION A LA BASE DE DATOS
/*--------------------------------------------------------------*/

public function db_disconnect()
{
  if(isset($this->con))
  {
    mysqli_close($this->con);
    unset($this->con); /*Destrentencia variable*/
  }
}
/*--------------------------------------------------------------*/
/* FUNCION PARA HACER QUERIES
/*--------------------------------------------------------------*/
public function query($sql)
   {

      if (trim($sql != "")) {
          $this->query_id = $this->con->query($sql);
      }
      if (!$this->query_id)
              die("Error en esta consulta :<pre> " . $sql ."</pre>");
       return $this->query_id;

   }


/*--------------------------------------------------------------*/
 /* FUNCION PARA REMOVER CARACTERES ESPECIALES
 /* EN UNA CONSULTA
 /*--------------------------------------------------------------*/
 public function escape($str){
   return $this->con->real_escape_string($str);
 }
 /*--------------------------------------------------------------*/
 /* Funciones principales para los QUERIES
 /*--------------------------------------------------------------*/
   public function fetch_array($sentencia)
   {
     return mysqli_fetch_array($sentencia);
   }
   public function fetch_object($sentencia)
   {
     return mysqli_fetch_object($sentencia);
   }
   public function fetch_assoc($sentencia)
   {
     return mysqli_fetch_assoc($sentencia);
   }
   public function num_rows($sentencia)
   {
     return mysqli_num_rows($sentencia);
   }
   public function insert_id()
   {
     return mysqli_insert_id($this->con);
   }
   public function affected_rows()
   {
     return mysqli_affected_rows($this->con);
   }


/*--------------------------------------------------------------*/
/* FUNCION DE UN LOOP WHILE
/*--------------------------------------------------------------*/
public function while_loop($loop){
 global $db;
   $results = array();
   while ($result = $this->fetch_array($loop)) {
      $results[] = $result;
   }
 return $results;
}

}



$db = new MySqli_DB();

?>
