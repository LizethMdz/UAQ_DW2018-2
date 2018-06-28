<?php
$page_title = 'Reporte de ventas';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
  if(isset($_POST['submit'])){
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);

    if(empty($errors)):
      $start_date   = remove_junk($db->escape($_POST['start-date']));
      $end_date     = remove_junk($db->escape($_POST['end-date']));
      $results      = find_sale_by_dates($start_date,$end_date);
    else:
      $session->msg("d", $errors);
      redirect('sales_report.php', false);
    endif;

  } else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="panel-control" style="background: white;">


<?php if($results): ?>
          <div class="tabla-encabezado">
            <i class="far fa-file-alt table-icon"></i>
            <p>DESGLOSE DEL REPORTE</p>
          </div>

          <table class="tabla-reporte-titulo">
            <thead>
            <tr>
              <th style="background: #BDC3C7; color: white;">REPORTE DE VENTAS</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>FECHA: <?php if(isset($start_date)){ echo $start_date;}?> a <?php if(isset($end_date)){echo $end_date;}?></td>
            </tr>
          </tbody>

          </table>

          <table class="tabla-reporte" cellpadding="10">
            <thead>
            <tr>
              <th>Fecha</th>
              <th>Descripcion</th>
              <th>Precio de compra</th>
              <th>Precio de venta</th>
              <th>Cantidad total</th>
              <th>TOTAL</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $result): ?>
            <tr>
              <td><?php echo remove_junk($result['date']);?></td>
              <td><?php echo remove_junk(ucfirst($result['name']));?></td>
              <td><?php echo remove_junk($result['buy_price']);?></td>
              <td><?php echo remove_junk($result['sale_price']);?></td>
              <td><?php echo remove_junk($result['total_sales']);?></td>
              <td><?php echo remove_junk($result['total_saleing_price']);?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            <!--tfooter-->
            <tfoot>
            <tr>
              <td colspan="4"></td>
              <td>TOTAL</td>
              <td>$<?php echo number_format(@total_price($results)[0], 2);?></td>
            </tr>
            <tr>
              <td colspan="4"></td>
              <td>UTILIDAD</td>
              <td>$<?php echo number_format(@total_price($results)[1], 2);?></td>
            </tr>
            </tfoot>

          </table>
          <?php
            else:
                $session->msg("d", "No se encontraron ventas. ");
                redirect('sales_report.php', false);
             endif;
          ?>
    </div>

<?php include_once('layouts/footer.php'); ?>
