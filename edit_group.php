<?php
  $page_title = 'Editar Grupo';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  $e_group = find_by_id('user_groups',(int)$_GET['id']);
  if(!$e_group){
    $session->msg("d","Missing Group id.");
    redirect('group.php');
  }
?>
<?php
  if(isset($_POST['update'])){

   $req_fields = array('group-name','group-level');
   validate_fields($req_fields);
   if(empty($errors)){
           $name = remove_junk($db->escape($_POST['group-name']));
          $level = remove_junk($db->escape($_POST['group-level']));
         $status = remove_junk($db->escape($_POST['status']));

        $query  = "UPDATE user_groups SET ";
        $query .= "group_name='{$name}',group_level='{$level}',group_status='{$status}'";
        $query .= "WHERE ID='{$db->escape($e_group['id'])}'";
        $result = $db->query($query);
         if($result && $db->affected_rows() === 1){
          //sucess
          $session->msg('s',"Grupo se ha actualizado! ");
          redirect('edit_group.php?id='.(int)$e_group['id'], false);
        } else {
          //failed
          $session->msg('d','Lamentablemente no se ha actualizado el grupo!');
          redirect('edit_group.php?id='.(int)$e_group['id'], false);
        }
   } else {
     $session->msg("d", $errors);
    redirect('edit_group.php?id='.(int)$e_group['id'], false);
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

<div class="panel-control" style="background: white;">
        <div class="form-grupo">
          <p class="text-titulos">Editar Grupo</p>
          <form method="post" action="edit_group.php?id=<?php echo (int)$e_group['id'];?>">
          <p class="text-subtitulos">Nombre del Grupo</p>
          <input type="name" placeholder="Grupo" class="input-grp" name="group-name" value="<?php echo remove_junk(ucwords($e_group['group_name'])); ?>">
          <p  class="text-subtitulos">Nivel del Grupo</p>
          <input type="number" placeholder="Nivel" class="input-grp" name="group-level" value="<?php echo (int)$e_group['group_level']; ?>">
          <p  class="text-subtitulos">Estado</p>
           <select class="select-st" name="status">
            <option <?php if($e_group['group_status'] === '1') echo 'selected="selected"';?> value="1"> Activo </option>
            <option <?php if($e_group['group_status'] === '0') echo 'selected="selected"';?> value="0">Inactivo</option>
            </select>
          <button type="submit" class="btn-e-c" name="update">
            Cambiar
          </button>
        </form>
        </div>
     </div>


<?php include_once('layouts/footer.php'); ?>
