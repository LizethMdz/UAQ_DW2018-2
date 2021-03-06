<?php
  $page_title = 'Lista de grupos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
  $all_groups = find_all('user_groups');
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

<div class="row">

    <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <strong>
        <i class="fas fa-users table-icon"></i>
        <span>Grupos</span>
     </strong>
       <a href="add_group.php" class="btn btn-info pull-right btn-sm"> Agregar grupo</a>
    </div>
     <div class="panel-body">
      <table class="table-group">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th>Nombre del grupo</th>
            <th class="text-center" style="width: 20%;">Nivel del grupo</th>
            <th class="text-center" style="width: 15%;">Estado</th>
            <th class="text-center" style="width: 100px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($all_groups as $a_group): ?>
          <tr height="50px">
           <td class="text-center"><?php echo count_id();?></td>
           <td><?php echo remove_junk(ucwords($a_group['group_name']))?></td>
           <td class="text-center">
             <?php echo remove_junk(ucwords($a_group['group_level']))?>
           </td>
           <td class="text-center">
           <?php if($a_group['group_status'] === '1'): ?>
            <span class="estado-A"><?php echo "Activo"; ?></span>
          <?php else: ?>
            <span class="estado-I"><?php echo "Inactivo"; ?></span>
          <?php endif;?>
           </td>
           <td class="text-center">
             <div class="">
                    <a href="edit_group.php?id=<?php echo (int)$a_group['id'];?>" class="btn btn-edit"  title="Editar" data-toggle="tooltip">Editar</a>
                    <a a href="delete_group.php?id=<?php echo (int)$a_group['id'];?>" class="btn btn-eliminar"  title="Eliminar" data-toggle="tooltip"><i class="fa fa-trash"></i> Trash</a>
                  </div>
           </td>
          </tr>
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
    </div>

</div>
  <?php include_once('layouts/footer.php'); ?>
