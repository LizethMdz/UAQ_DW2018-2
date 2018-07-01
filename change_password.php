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

<div class="panel-control" style="background: white; height: 500px;">
        <div class="form-ch-pass">
          <p style="color: #3458C1; margin-left: 50px; font-size: 24px;
          ">Cambiar Contraseña</p>
          <form method="post" action="change_password.php">
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

<?php include_once('layouts/footer.php'); ?>
