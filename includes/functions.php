<?php
 $errors = array();

 /*--------------------------------------------------------------*/
 /* FUNCION QUE ELIMINA CUALQUIER CARACTER EN UNA SENTENCIA SQL
 /*--------------------------------------------------------------*/
function real_escape($string){
  global $con;
  $escape = mysqli_real_escape_string($con,$string);
  return $escape;
}
/*--------------------------------------------------------------*/
/* FUNCION QUE ELIMINA CARACTERES ESPECIALES POR HTML
/*--------------------------------------------------------------*/
function remove_junk($string){
  /*Inserta un salto de linea por linea*/
  $string = nl2br($string);
  /*Traduccion de comilla doble y etiquetas*/
  $string = htmlspecialchars(strip_tags($string, ENT_QUOTES));
  return $string;
}
/*--------------------------------------------------------------*/
/* FUNCION QUE COLOCA UNA LETRA MAYUSCULA AL INICIO DE DE UNA PALABRA
/*--------------------------------------------------------------*/
function first_character($string){
  $val = str_replace('-'," ",$string);
  /*Para convertir la primera letra en mayuscula*/
  $val = ucfirst($val);
  return $val;
}
/*--------------------------------------------------------------*/
/* FUNCION QUE VALIDA LOS CAMPOS DE ENTRADA
/*--------------------------------------------------------------*/
function validate_fields($var){
  global $errors;
  foreach ($var as $field) {
    $val = remove_junk($_POST[$field]);
    if(isset($val) && $val==''){
      $errors = $field ." No puede estar en blanco.";
      return $errors;
    }
  }
}
/*--------------------------------------------------------------*/
/* FUNCION QUE MUESTRA UN MENSAJE EN PANTALLA
/*--------------------------------------------------------------*/
function display_msg($msg =''){
   $output = array();
   if(!empty($msg)) {
      foreach ($msg as $key => $value) {
         $output  = "<div>";
         $output .= remove_junk(first_character($value));
         $output .= "</div>";
      }
      return $output;
   } else {
     return "" ;
   }
}
/*--------------------------------------------------------------*/
/* FUNCION PARA REDIRECCIONAR A OTRA VISTA
/*--------------------------------------------------------------*/
function redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
      header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
/*------------------------------------------------------------------------*/
/* FUNCION QUE DETERMINA EL TOTAL DE UNA VENTA CON PRECIO Y NO. DE PIEZAS
/*------------------------------------------------------------------------*/
function total_price($totals){
   $sum = 0;
   $sub = 0;
   foreach($totals as $total ){
     $sum += $total['total_saleing_price'];
     $sub += $total['total_buying_price'];
     $profit = $sum - $sub;
   }
   return array($sum,$profit);
}
/*--------------------------------------------------------------*/
/* FUNCION QUE HACE LEGIBLE UNA FECHA
/*--------------------------------------------------------------*/
function read_date($str){
    date_default_timezone_set("America/Mexico_City");
     if($str)
      return date('d/m/Y', strtotime($str));
     else
      return null;
  }
/*--------------------------------------------------------------*/
/* FUNCION QUE DA FORMATO A LA FECHA
/*--------------------------------------------------------------*/
function make_date(){
  date_default_timezone_set("America/Mexico_City");
  return strftime("%Y-%m-%d %H:%M:%S", time());
}
/*--------------------------------------------------------------*/
/* FUNCION CONTADOR POR ID
/*--------------------------------------------------------------*/
function count_id(){
  static $count = 1;
  return $count++;
}
/*--------------------------------------------------------------*/
/* FUNCION QUE CREA UN STRING ALEATORIO 0-Z
/*--------------------------------------------------------------*/
function randString($length = 5)
{
  $str='';
  $cha = "0123456789abcdefghijklmnopqrstuvwxyz";

  for($x=0; $x<$length; $x++)
   $str .= $cha[mt_rand(0,strlen($cha))];
  return $str;
}


?>
