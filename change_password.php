<?php
  $page_title = 'Cambiar contraseña';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>
<?php $user = current_user(); ?>
<?php
  if(isset($_POST['update'])){

    $req_fields = array('new-password','old-password','id' );
    validate_fields($req_fields);

    if(empty($errors)){

             if(sha1($_POST['old-password']) !== current_user()['password'] ){
               $session->msg('d', "Tu antigua contraseña no coincide");
               redirect('change_password.php',false);
             }

            $id = (int)$_POST['id'];
            $new = remove_junk($db->escape(sha1($_POST['new-password'])));
            $sql = "UPDATE users SET password ='{$new}' WHERE id='{$db->escape($id)}'";
            $result = $db->query($sql);
                if($result && $db->affected_rows() === 1):
                  $session->logout();
                  $session->msg('s',"Inicia sesión con tu nueva contraseña.");
                  redirect('index.php', false);
                else:
                  $session->msg('d',' Lo siento, actualización falló.');
                  redirect('change_password.php', false);
                endif;
    } else {
      $session->msg("d", $errors);
      redirect('change_password.php',false);
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

<div class="panel-control" style="background: white; height: 500px;">
        <div class="form-ch-pass">
          <p style="color: #3458C1; margin-left: 50px; font-size: 24px;
          ">Cambiar Contraseña</p>
          <form action="
          ">
          <p style="margin-top: 30px; margin-left: 25px;
          color:#3458C1; font-size: 14px;">Nueva Contraseña</p>
          <input type="password" placeholder="Nueva Contraseña" class="input-ch-p" name="new-password">
          <p style="margin-left: 25px;
          color:#3458C1; font-size: 14px;">Antigua Contraseña</p>
          <input type="password" placeholder="Antigua Contraseña" class="input-ch-p" name="old-password">
          <input type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
          <button type="submit" style="padding: 10px;
          margin-left: 25px; margin-top: 25px; background: #5BC0DE; color:#fff;" name="update">
            Cambiar
          </button>
        </form>
        </div>
     </div>
<!--
<div class="login-page">
    <div class="text-center">
       <h3>Cambiar contraseña</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="change_password.php" class="clearfix">
        <div class="form-group">
              <label for="newPassword" class="control-label">Nueva contraseña</label>
              <input type="password" class="form-control" name="new-password" placeholder="Nueva contraseña">
        </div>
        <div class="form-group">
              <label for="oldPassword" class="control-label">Antigua contraseña</label>
              <input type="password" class="form-control" name="old-password" placeholder="Antigua contraseña">
        </div>
        <div class="form-group clearfix">
               <input type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
                <button type="submit" name="update" class="btn btn-info">Cambiar</button>
        </div>
    </form>
</div>-->
<?php include_once('layouts/footer.php'); ?>
