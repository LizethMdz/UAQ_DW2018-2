<?php
  $page_title = 'Edit sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$sale = find_by_id('sales',(int)$_GET['id']);
if(!$sale){
  $session->msg("d","Missing product id.");
  redirect('sales.php');
}
?>
<?php $product = find_by_id('products',$sale['product_id']); ?>
<?php

  if(isset($_POST['update_sale'])){
    $req_fields = array('title','quantity','price','total', 'date' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$product['id']);
          $s_qty     = $db->escape((int)$_POST['quantity']);
          $s_total   = $db->escape($_POST['total']);
          $date      = $db->escape($_POST['date']);
          $s_date    = date("Y-m-d", strtotime($date));

          $sql  = "UPDATE sales SET";
          $sql .= " product_id= '{$p_id}',qty={$s_qty},price='{$s_total}',date='{$s_date}'";
          $sql .= " WHERE id ='{$sale['id']}'";
          $result = $db->query($sql);
          if( $result && $db->affected_rows() === 1){
                    update_product_qty($s_qty,$p_id);
                    $session->msg('s',"Sale updated.");
                    redirect('edit_sale.php?id='.$sale['id'], false);
                  } else {
                    $session->msg('d',' Sorry failed to updated!');
                    redirect('sales.php', false);
                  }
        } else {
           $session->msg("d", $errors);
           redirect('edit_sale.php?id='.(int)$sale['id'],false);
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

<div class="panel-control" style="background: transparent;">
        <div class="tabla media sales">
          <div class="tabla-encabezado">
            <i class="far fa-edit table-icon"></i>
            <p>TODAS LAS VENTAS</p>
            <a href="sales.php" class="enlace-sales">Ver todas las ventas</a>
          </div>

          <div class="contenedor-tabla sales">
            <p style="margin-top: 15px; margin-left: 50px;
          color: #9BA8C5; font-size: 20px;">Informacion del la venta</p>
            <table class="tabla-sales" cellpadding="5" >
              <thead>
              <tr>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Fecha</th>
                <th width="30%">Acción</th>
                  </thead>
            <tbody>
              <tr>
                <form method="post" action="edit_sale.php?id=<?php echo (int)$sale['id']; ?>">
                <td style="height: 50px;"><input type="text" class="input-sales" name="title" value="<?php echo remove_junk($product['name']); ?>" ></td>
                <td style="height: 50px;"><input type="text" class="input-sales" name="quantity" value="<?php echo (int)$sale['qty']; ?>"></td>
                <td style="height: 50px;"><input type="text" class="input-sales" name="price" value="<?php echo remove_junk($product['sale_price']); ?>"></td>
                <td style="height: 50px;"><input type="text" class="input-sales" name="total" value="<?php echo remove_junk($sale['price']); ?>"></td>
                <td style="height: 50px;"><input type="date" class="input-sales" name="date" data-date-format="" value="<?php echo remove_junk($sale['date']); ?>"></td>
                <td style="height: 50px;"><button type="submit" name="update_sale" class="btn-sales">Actualizar</button></td>
              </form>
              </tr>

            </tbody>
            </table>
          </div>
        </div>
     </div>



<?php include_once('layouts/footer.php'); ?>
