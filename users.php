<?php
  $page_title = 'Lista de usuarios';
  require_once('includes/load.php');
?>
<?php
// Checkin What level user has permission to view this page
 page_require_level(1);
//pull out all user form database
 $all_users = find_all_user();
?>
<?php include_once('layouts/header2.php'); ?>
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
          <i class="fas fa-user-friends table-icon"></i>
          <span style="left:10px;">Usuarios</span>
       </strong>
         <a href="add_user.php" class="btn btn-info pull-right">Agregar usuario</a>
      </div>
     <div class="panel-body">
      <table class="table-user">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th>Nombre </th>
            <th>Usuario</th>
            <th class="text-center" style="width: 15%;">Rol de usuario</th>
            <th class="text-center" style="width: 10%;">Estado</th>
            <th style="width: 20%;">Último login</th>
            <th class="text-center" style="width: 100px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($all_users as $a_user): ?>
          <tr height="50px">
           <td class="text-center"><?php echo count_id();?></td>
           <td><?php echo remove_junk(ucwords($a_user['name']))?></td>
           <td><?php echo remove_junk(ucwords($a_user['username']))?></td>
           <td class="text-center"><?php echo remove_junk(ucwords($a_user['group_name']))?></td>
           <td class="text-center">
           <?php if($a_user['status'] === '1'): ?>
            <span class="label label-success"><?php echo "Activo"; ?></span>
          <?php else: ?>
            <span class="label label-danger"><?php echo "Inactivo"; ?></span>
          <?php endif;?>
           </td>
           <td><?php echo read_date($a_user['last_login'])?></td>
           <td class="text-center">
             <div class="">
                    <a href="edit_user.php?id=<?php echo (int)$a_user['id'];?>" class="btn btn-edit"  title="Editar" data-toggle="tooltip">Editar</a>
                    <a href="delete_user.php?id=<?php echo (int)$a_user['id'];?>" class="btn btn-eliminar"  title="Eliminar" data-toggle="tooltip"><i class="fa fa-trash"></i> Trash</a>
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
