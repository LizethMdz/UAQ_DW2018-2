<?php
$page_title = 'Reporte de ventas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php include_once('layouts/header2.php'); ?>
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



<!--
>>>>>>> master
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="panel">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
          <form class="clearfix" method="post" action="sale_report_process.php">
            <div class="form-group">
              <label class="form-label">Rango de fechas</label>
                <div class="input-group">
                  <input type="text" class="datepicker form-control" name="start-date" placeholder="From">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" name="end-date" placeholder="To">
                </div>
            </div>
            <div class="form-group">
                 <button type="submit" name="submit" class="btn btn-primary">Generar Reporte</button>
            </div>
          </form>
      </div>

    </div>
  </div>

</div>-->
<?php include_once('layouts/footer.php'); ?>
