<?php
  $page_title = 'Ventas mensuales';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
 $year = date('Y');
 $sales = monthlySales($year);
?>
<?php include_once('layouts/header.php'); ?>
<<<<<<< HEAD
=======

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


     <!--VENTAS MENSUALES-->

       <div class="tabla media">
          <div class="tabla-encabezado">
           <i class="fas fa-money-check-alt table-icon"></i>
           <p>VENTAS MENSUALES</p>
         </div>
         <div class="contenedor-tabla">
         <table border="1px" class="tabla-datos">
         <thead>
           <tr>
             <th>#</th>
             <th>Descripcion</th>
             <th>Cantidad de Vendidas</th>
             <th>Total</th>
             <th>Fecha</th>
           </tr>
         </thead>
         <tbody>
            <?php foreach ($sales as $sale):?>
              <tr>
                <td><?php echo count_id();?></td>
                <td><?php echo remove_junk($sale['name']); ?></td>
                <td><?php echo (int)$sale['qty']; ?></td>
                <td><?php echo remove_junk($sale['total_saleing_price']); ?></td>
                <td><?php echo date("d/m/Y", strtotime ($sale['date'])); ?></td>
             </tr>

         </tbody>
        <?php endforeach;?>
       </table>
       </div>
       </div>

 </div>

<?php include_once('layouts/footer.php'); ?>
