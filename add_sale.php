<?php
  $page_title = 'Agregar venta';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php

  if(isset($_POST['add_sale'])){
    $req_fields = array('s_id','quantity','price','total', 'date' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$_POST['s_id']);
          $s_qty     = $db->escape((int)$_POST['quantity']);
          $s_total   = $db->escape($_POST['total']);
          $date      = $db->escape($_POST['date']);
          $s_date    = make_date();

          $sql  = "INSERT INTO sales (";
          $sql .= " product_id,qty,price,date";
          $sql .= ") VALUES (";
          $sql .= "'{$p_id}','{$s_qty}','{$s_total}','{$s_date}'";
          $sql .= ")";

                if($db->query($sql)){
                  update_product_qty($s_qty,$p_id);
                  $session->msg('s',"Venta agregada ");
                  redirect('add_sale.php', false);
                } else {
                  $session->msg('d','Lo siento, registro falló.');
                  redirect('add_sale.php', false);
                }
        } else {
           $session->msg("d", $errors);
           redirect('add_sale.php',false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>

<!--ERRORES O MENSAJES-->
<?php
if (isset($msg)){
?>
<div class="alerta" >
  <?php
  echo display_msg($msg); ?>
  <script src="jquery/jquery-3.3.1.min.js"></script>
  <script>
        $(document).ready(function() {
            setTimeout(function() {
              $(".alerta").fadeOut(2000);
            },1000);
        });
  </script>
<?php
  }
 ?>

</div>

<div class="panel-control">
        <div class="input-busq">
          <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
          <button type="submit" class="btn-buscar">Colocar en Lista</button>
          <input type="text" id="sug_input"  name="title" placeholder="Buscar por el nombre del producto" class="input-grp busc">
          <div id="result" class="list-group">
          </div>
        </form>
        </div>
        <div class="form-sale">
          <div class="tabla-encabezado">
            <i class="far fa-edit table-icon"></i>
            <p>EDITAR VENTA</p>
          </div>
            <div class="contenedor-tabla" style="background: white;">
          <form method="post" action="add_sale.php">
          <table border="1px" class="tabla-datos bord">
          <thead>
            <tr>
              <th class="title-enc">Producto</th>
              <th class="title-enc">Precio</th>
              <th class="title-enc">Cantidad</th>
              <th class="title-enc">Total</th>
              <th class="title-enc">Agregado</th>
              <th class="title-enc">Acciones</th>
            </tr>
          </thead>
          <tbody  id="product_info"> </tbody>
          <!--<tbody>

            <tr>
                 <td>fdfds</td>
                 <td>fsdfds</td>
                 <td>ddjskldsd</td>
                 <td>iojklj</td>
                 <td>hfghfg</td>
                 <td colspan="2">
                  <a href="#" class="btn-ico">
                    <span><i class="far fa-edit"></i></span>
                  </a>
                  <a href="#" class="btn-ico">
                     <span><i class="fas fa-trash-alt"></i></span>
                  </a></td>
              </tr>
          </tbody>-->

        </table>
        </form>
        </div>
        </div>
     </div>
<!--
>>>>>>> master
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Búsqueda</button>
            </span>
            <input type="text" id="sug_input" class="form" name="title"  placeholder="Buscar por el nombre del producto" >
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Editar venta</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php">
         <table class="table table-bordered">
           <thead>
            <th> Producto </th>
            <th> Precio </th>
            <th> Cantidad </th>
            <th> Total </th>
            <th> Agregado</th>
            <th> Acciones</th>
           </thead>
             <tbody  id="product_info"> </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>

</div>-->

<?php include_once('layouts/footer.php'); ?>
