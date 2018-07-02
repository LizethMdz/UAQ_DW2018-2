<?php
  require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* FUNCION QUE ENCUENTRA TODOS LOS REGISTROS DE UNA TABLA
/*--------------------------------------------------------------*/
function find_all($tabla) {
   global $db;
   if(tableExists($tabla))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($tabla));
   }
}
/*--------------------------------------------------------------*/
/* FUNCION PARA HACER QUERIES
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/*  FUNCION QUE ENCUENTRA LOS DATOS DE UN REGISTRO POR ID Y TABLA
/*--------------------------------------------------------------*/
function find_by_id($tabla,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($tabla)){
          $sql = $db->query("SELECT * FROM {$db->escape($tabla)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* FUNCION QUE BORRA UN REGISTRO DE UNA TABLA POR UN ID
/*--------------------------------------------------------------*/
function delete_by_id($tabla,$id)
{
  global $db;
  if(tableExists($tabla))
   {
    $sql = "DELETE FROM ".$db->escape($tabla);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* FUNCION QUE CUENTA REGISTROS QUE TENGAN UN MISMO ID
/*--------------------------------------------------------------*/

function count_by_id($tabla){
  global $db;
  if(tableExists($tabla))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($tabla);
    $resultado = $db->query($sql);
     return($db->fetch_assoc($resultado));
  }
}
/*--------------------------------------------------------------*/
/* FUNCION QUE DETERMINA SI UNA TABLA EXISTE EN LA BASE DE DATOS
/*--------------------------------------------------------------*/
function tableExists($tabla){
  global $db;
  $tabla_existe = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($tabla).'"');
      if($tabla_existe) {
        if($db->num_rows($tabla_existe) > 0)
              return true;
         else
              return false;
      }
  }
 /*--------------------------------------------------------------*/
 /* Autenticacion de los datos del login.
 /* Username, Password
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password); //Verifica el hash de un string
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }

  /*--------------------------------------------------------------*/
  /* FUNCION QUE ENCUENTRA EL SESSION ID DEL USUARIO ACTUAL
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
        endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* FUNCION QUE IDENTIFICA EL USUARIO Y SU GRUPO AL QUE PERTENECE
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $resultado = find_by_sql($sql);
      return $resultado;
  }
  /*--------------------------------------------------------------*/
  /* FUNCION QUE REGISTRA EL ULTIMO ACCESO AL SISTEMA
  /*--------------------------------------------------------------*/

 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $resultado = $db->query($sql);
    return ($resultado && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* FUNCION QUE ENCIENTRA UN REGISTRO DE UN GRUPO EN BASE A SU NOMBRE
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $resultado = $db->query($sql);
    return($db->num_rows($resultado) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* FUNCION QUE DETERMINA EL NIVEL DE UN GRUPO
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $resultado = $db->query($sql);
    return($db->num_rows($resultado) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* FUNCION QUE EVALUA EL USUARIO LOGEADO
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     $login_level = find_by_groupLevel($current_user['user_level']);
     //SI NO HAY UN USUARIO LOGEADO
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Por favor Iniciar sesión...');
            redirect('index.php', false);
      //SI NO HAY UN ESTATUS DE UN GRUPO
     elseif($login_level['group_status'] === '0'):
           $session->msg('d','Este nivel de usaurio esta inactivo!');
           redirect('home.php',false);
      //EVALUA EL NIVEL DE UN USUARIO Y ESTE ESTE DENTRO DEL RANGO
     elseif($current_user['user_level'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "¡Lo siento!  no tienes permiso para ver la página.");
            redirect('home.php', false);
      endif;

     }
   /*--------------------------------------------------------------*/
   /* FUUNCION QUE ENLAZA EL PRODUCTO CON SU IMAGEN CORRESPONDIENTE Y LA CATEGORIA
   /*--------------------------------------------------------------*/
  function join_product_table(){
     global $db;
     $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
    $sql  .=" AS categorie,m.file_name AS image";
    $sql  .=" FROM products p";
    $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
    $sql  .=" ORDER BY p.id ASC";
    return find_by_sql($sql);

   }
  /*--------------------------------------------------------------*/
  /* FUNCION QUE DESPLIEGA EL NOMBRE DE UN PRODUCTO SI CORRESPONDE AL MISMO
  /*
  /*--------------------------------------------------------------*/

   function find_product_by_title($product_name){
     global $db;
     $p_name = remove_junk($db->escape($product_name));
     $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 5";
     $resultado = find_by_sql($sql);
     return $resultado;
   }

  /*--------------------------------------------------------------*/
  /* FUNCION QUE ENCUENTRA TODOS LOS PRODUCTOS QUE TENGAN EL MISMO NOMBRE
  /*
  /*--------------------------------------------------------------*/
  function find_all_product_info_by_title($title){
    global $db;
    $sql  = "SELECT * FROM products ";
    $sql .= " WHERE name ='{$title}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* FUNCION QUE ACTUALIZA LA CANTIDAD DE PRODUCTOS
  /*--------------------------------------------------------------*/
  function update_product_qty($qty,$p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity=quantity -'{$qty}' WHERE id = '{$id}'";
    $resultado = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  /*--------------------------------------------------------------*/
  /* FUUNCION QUE ENCUENTRA EL PRODUCTO RECIENTE
  /*--------------------------------------------------------------*/
 function find_recent_product_added($limit){
   global $db;
   $sql   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS categorie,";
   $sql  .= "m.file_name AS image FROM products p";
   $sql  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
   $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
   $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* FUNCION QUE ENCUENTRA LA VENTA MAS ALTA O COMUN
 /*--------------------------------------------------------------*/
 function find_higest_saleing_product($limit){
   global $db;
   $sql  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.qty) AS totalQty";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON p.id = s.product_id ";
   $sql .= " GROUP BY s.product_id";
   $sql .= " ORDER BY SUM(s.qty) DESC LIMIT ".$db->escape((int)$limit);
   return $db->query($sql);
 }
 /*--------------------------------------------------------------*/
 /* FUNCION QUE DEVUELVE TODAS LAS VENTAS
 /*--------------------------------------------------------------*/
 function find_all_sale(){
   global $db;
   $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON s.product_id = p.id";
   $sql .= " ORDER BY s.date DESC";
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* FUNCION QUE DETERMINA LA ULTIMA VENTA
 /*--------------------------------------------------------------*/
function find_recent_sale_added($limit){
  global $db;
  $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " ORDER BY s.date DESC LIMIT ".$db->escape((int)$limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* FUNCION QUE EVALUA DOS FECHAS Y GENERA UN REPORTE DE LAS VENTAS
/*--------------------------------------------------------------*/
function find_sale_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date, p.name,p.sale_price,p.buy_price,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  $sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.date),p.name";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* FUNCION QUE GENERA UN REPORTE DIARIO DE LAS VENTAS
/*--------------------------------------------------------------*/
function  dailySales($year,$month){
  global $db;
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m' ) = '{$year}-{$month}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%e' ),s.product_id";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* FUNCION QUE GENERA UN REPORTE MENSUAL DE LAS VENTAS
/*--------------------------------------------------------------*/
function  monthlySales($year){
  global $db;
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y' ) = '{$year}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%c' ),s.product_id";
  $sql .= " ORDER BY date_format(s.date, '%c' ) ASC";
  return find_by_sql($sql);
}

?>
