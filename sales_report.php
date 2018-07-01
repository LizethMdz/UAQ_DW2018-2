<?php
$page_title = 'Reporte de ventas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
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
              $(".alerta").fadeOut(1500);
            },1000);
        });
  </script>
<?php
  }
 ?>

</div>
<div class="panel-control">

     <!--POR FECHA-->

       <div class="tabla rpventas">
          <div class="tabla-encabezado">
           <i class="far fa-calendar-alt table-icon"></i>
           <p>RANGO DE FECHAS</p>
         </div>
         <div class="contenedor-fechas" method="post">
           <form action="sale_report_process.php" method="post">
           <input type="text" name="start-date" class="input-fecha" placeholder="De:"
           onfocus="(this.type='date')" onblur="(this.type='text')" name="start-date">
           <span class="icon-date"><i class="fas fa-chevron-right"></i></span>
           <input type="text" name="end-date" class="input-fecha" placeholder="A:"
           type="text" onfocus="(this.type='date')" onblur="(this.type='text')" name="end-date">
           <button type="submit" name="submit" class="button-2 purple">
           <!--<a href="#">-->
          <span><i class="fas fa-plus-square"></i></span>Generar Registro
           </button>
           </form>
         </div>
       </div>

 </div>

<?php include_once('layouts/footer.php'); ?>
