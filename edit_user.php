<?php
  $page_title = 'Editar Usuario';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  $e_user = find_by_id('users',(int)$_GET['id']);
  $groups  = find_all('user_groups');
  if(!$e_user){
    $session->msg("d","Missing user id.");
    redirect('users.php');
  }
?>

<?php
//Update User basic info
  if(isset($_POST['update'])) {
    $req_fields = array('name','username','level');
    validate_fields($req_fields);
    if(empty($errors)){
             $id = (int)$e_user['id'];
           $name = remove_junk($db->escape($_POST['name']));
       $username = remove_junk($db->escape($_POST['username']));
          $level = (int)$db->escape($_POST['level']);
       $status   = remove_junk($db->escape($_POST['status']));
            $sql = "UPDATE users SET name ='{$name}', username ='{$username}',user_level='{$level}',status='{$status}' WHERE id='{$db->escape($id)}'";
         $result = $db->query($sql);
          if($result && $db->affected_rows() === 1){
            $session->msg('s',"Acount Updated ");
            redirect('edit_user.php?id='.(int)$e_user['id'], false);
          } else {
            $session->msg('d',' Lo siento no se actualizó los datos.');
            redirect('edit_user.php?id='.(int)$e_user['id'], false);
          }
    } else {
      $session->msg("d", $errors);
      redirect('edit_user.php?id='.(int)$e_user['id'],false);
    }
  }
?>
<?php
// Update user password
if(isset($_POST['update-pass'])) {
  $req_fields = array('password');
  validate_fields($req_fields);
  if(empty($errors)){
           $id = (int)$e_user['id'];
     $password = remove_junk($db->escape($_POST['password']));
     $h_pass   = sha1($password);
          $sql = "UPDATE users SET password='{$h_pass}' WHERE id='{$db->escape($id)}'";
       $result = $db->query($sql);
        if($result && $db->affected_rows() === 1){
          $session->msg('s',"Se ha actualizado la contraseña del usuario. ");
          redirect('edit_user.php?id='.(int)$e_user['id'], false);
        } else {
          $session->msg('d','No se pudo actualizar la contraseña de usuario..');
          redirect('edit_user.php?id='.(int)$e_user['id'], false);
        }
  } else {
    $session->msg("d", $errors);
    redirect('edit_user.php?id='.(int)$e_user['id'],false);
  }
}

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

<div class="panel-control" style="background: white;">
        <div class="tabla categoria arriba" style="margin-left: 40px;">
          <div class="tabla-encabezado">
            <i class="fas fa-user-tie table-icon"></i>
              <p>ACTUALIZA CUENTA: <?php echo remove_junk(ucwords($e_user['name'])); ?></p>

          </div>

          <div class="cont-data izqui">
            <p class="text-subtitulos">Nombres</p>
            <input type="name" name="name" class="input-e" value="<?php echo remove_junk(ucwords($e_user['name'])); ?>">
            <p class="text-subtitulos">Usuario</p>
            <input type="text" name="username" class="input-e" value="<?php echo remove_junk(ucwords($e_user['username'])); ?>">
            <p class="text-subtitulos">Rol de Usuario</p>
          <select class="select-st-u" name="level" style="margin-top: 10px;">
            <?php foreach ($groups as $group ):?>
             <option <?php if($group['group_level'] === $e_user['user_level']) echo 'selected="selected"';?> value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
          <?php endforeach;?>

            </select>

            <p class="text-subtitulos">Estado</p>
          <select class="select-st-u" name="" style="margin-top: 10px;">
            <option <?php if($e_user['status'] === '1') echo 'selected="selected"';?>value="1">Activo</option>
            <option <?php if($e_user['status'] === '0') echo 'selected="selected"';?> value="0">Inactivo</option>
            </select>

            <button type="submit" name="" class="button orange btn-actu">
                <span><i class="fas fa-pen-square"></i></span>Actualizar
            </button>
          </div>

        </div>

        <!--CAMBIO DE CONTRASEÑA -->
        <div class="tabla categoria amplitud">
           <div class="tabla-encabezado">
            <i class="fas fa-key table-icon"></i>
              <p>CAMBIAR <?php echo remove_junk(ucwords($e_user['name'])); ?> CONTRASEÑA</p>
          </div>
          <div class="contenedor-tabla">

          <form action="edit_user.php?id=<?php echo (int)$e_user['id'];?>" method="post">
          <p class="text-subtitulos">Contraseña</p>
          <input type="password" class="input-e" name="password" placeholder="Introduce la nueva Contraseña">


          <button type="submit" name="update-pass" class="btn-ch-password">
            Cambiar
          </button>



        </form>
        </div>
        </div>
     </div>

<!--
 <div class="row">
   <div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
  <div class="col-md-6">
     <div class="panel panel-default">
       <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Actualiza cuenta <?php echo remove_junk(ucwords($e_user['name'])); ?>
        </strong>
       </div>
       <div class="panel-body">
          <form method="post" action="edit_user.php?id=<?php echo (int)$e_user['id'];?>" class="clearfix">
            <div class="form-group">
                  <label for="name" class="control-label">Nombres</label>
                  <input type="name" class="form-control" name="name" value="<?php echo remove_junk(ucwords($e_user['name'])); ?>">
            </div>
            <div class="form-group">
                  <label for="username" class="control-label">Usuario</label>
                  <input type="text" class="form-control" name="username" value="<?php echo remove_junk(ucwords($e_user['username'])); ?>">
            </div>
            <div class="form-group">
              <label for="level">Rol de usuario</label>
                <select class="form-control" name="level">
                  <?php foreach ($groups as $group ):?>
                   <option <?php if($group['group_level'] === $e_user['user_level']) echo 'selected="selected"';?> value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
              <label for="status">Estado</label>
                <select class="form-control" name="status">
                  <option <?php if($e_user['status'] === '1') echo 'selected="selected"';?>value="1">Activo</option>
                  <option <?php if($e_user['status'] === '0') echo 'selected="selected"';?> value="0">Inactivo</option>
                </select>
            </div>
            <div class="form-group clearfix">
                    <button type="submit" name="update" class="btn btn-info">Actualizar</button>
            </div>
        </form>
       </div>
     </div>
  </div>-->
  <!-- Change password form -->
  <!--
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Cambiar <?php echo remove_junk(ucwords($e_user['name'])); ?> contraseña
        </strong>
      </div>
      <div class="panel-body">
        <form action="edit_user.php?id=<?php echo (int)$e_user['id'];?>" method="post" class="clearfix">
          <div class="form-group">
                <label for="password" class="control-label">Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="Ingresa la nueva contraseña" required>
          </div>
          <div class="form-group clearfix">
                  <button type="submit" name="update-pass" class="btn btn-danger pull-right">Cambiar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>-->
<?php include_once('layouts/footer.php'); ?>
