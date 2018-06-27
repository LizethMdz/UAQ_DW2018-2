<?php
  $page_title = 'Editar Cuenta';
  require_once('includes/load.php');
   page_require_level(3);
?>
<?php
//update user image
  if(isset($_POST['submit'])) {
  $photo = new Media();
  $user_id = (int)$_POST['user_id'];
  $photo->upload($_FILES['file_upload']);
  if($photo->process_user($user_id)){
    $session->msg('s','La foto fue subida al servidor.');
    redirect('edit_account.php');
    } else{
      $session->msg('d',join($photo->errors));
      redirect('edit_account.php');
    }
  }
?>
<?php
 //update user other info
  if(isset($_POST['update'])){
    $req_fields = array('name','username' );
    validate_fields($req_fields);
    if(empty($errors)){
             $id = (int)$_SESSION['user_id'];
           $name = remove_junk($db->escape($_POST['name']));
       $username = remove_junk($db->escape($_POST['username']));
            $sql = "UPDATE users SET name ='{$name}', username ='{$username}' WHERE id='{$id}'";
    $result = $db->query($sql);
          if($result && $db->affected_rows() === 1){
            $session->msg('s',"Cuenta actualizada. ");
            redirect('edit_account.php', false);
          } else {
            $session->msg('d',' Lo siento, actualización falló.');
            redirect('edit_account.php', false);
          }
    } else {
      $session->msg("d", $errors);
      redirect('edit_account.php',false);
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

<div class="panel-control" >
        <div class="tabla" style="margin-left: 40px; width:45%;">
          <div class="tabla-encabezado">
            <i class="fas fa-camera-retro table-icon"></i>
              <p>Cambiar Foto</p>

          </div>

          <div class="cont-data direccion">
          <div class="img-up">
             <img  alt="user" width="100px" height="100px" style="border-radius: 50%;"
             src="uploads/users/<?php echo $user['image'];?>">
          </div>
          <form action="edit_account.php" method="POST" enctype="multipart/form-data">

            <input type="file" name="file_upload" class="input-categoria tamano">
            <input type="hidden" name="user_id" value="<?php echo $user['id'];?>">
            <button type="submit" name="submit" class="button orange pos">
            <!--<a href="#">-->
                <span><i class="fas fa-pen-square"></i></span>Cambiar
            </button>
          </form>
          </div>

        </div>


        <div class="tabla derech altura">
           <div class="tabla-encabezado">
            <i class="fas fa-user-edit table-icon"></i>
              <p>EDITAR MI CUENTA</p>
          </div>
          <div class="contenedor-tabla">

          <form method="post" action="edit_account.php?id=<?php echo (int)$user['id'];?>">
          <p style="margin-top: 15px; margin-left: 25px;
          color: #9BA8C5; font-size: 14px; font-weight: bold;">Nombres</p>
          <input type="name" class="input-e" name="name" value="<?php echo remove_junk(ucwords($user['name'])); ?>">
          <p style="margin-top: 15px; margin-left: 25px;
          color: #9BA8C5; font-size: 14px; font-weight: bold;">Usuario</p>
          <input type="text" class="input-e ed-user" name="username" value="<?php echo remove_junk(ucwords($user['username'])); ?>">

          <button style="padding: 10px;
          margin-left: 25px; margin-top: 25px; background: #5BC0DE; color:#fff; border-radius: 5px;" type="submit" name="update">
            Actualizar
          </button>

          <a href="change_password.php" class="btn-ch-c">Cambiar Contraseña</a>

        </form>
        </div>
        </div>
     </div>

<!--
  <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="panel-heading clearfix">
            <span class="glyphicon glyphicon-camera"></span>
            <span>Cambiar mi foto</span>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
                <img class="img-circle img-size-2" src="uploads/users/<?php echo $user['image'];?>" alt="">
            </div>
            <div class="col-md-8">
              <form class="form" action="edit_account.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <input type="file" name="file_upload" multiple="multiple" class="btn btn-default btn-file"/>
              </div>
              <div class="form-group">
                <input type="hidden" name="user_id" value="<?php echo $user['id'];?>">
                 <button type="submit" name="submit" class="btn btn-warning">Cambiar</button>
              </div>
             </form>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-edit"></span>
        <span>Editar mi cuenta</span>
      </div>
      <div class="panel-body">
          <form method="post" action="edit_account.php?id=<?php echo (int)$user['id'];?>" class="clearfix">
            <div class="form-group">
                  <label for="name" class="control-label">Nombres</label>
                  <input type="name" class="form-control" name="name" value="<?php echo remove_junk(ucwords($user['name'])); ?>">
            </div>
            <div class="form-group">
                  <label for="username" class="control-label">Usuario</label>
                  <input type="text" class="form-control" name="username" value="<?php echo remove_junk(ucwords($user['username'])); ?>">
            </div>
            <div class="form-group clearfix">
                    <a href="change_password.php" title="change password" class="btn btn-danger pull-right">Cambiar contraseña</a>
                    <button type="submit" name="update" class="btn btn-info">Actualizar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>-->


<?php include_once('layouts/footer.php'); ?>
