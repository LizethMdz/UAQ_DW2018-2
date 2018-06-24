<?php
  $page_title = 'Agregar usuarios';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  $groups = find_all('user_groups');
?>
<?php
  if(isset($_POST['add_user'])){

   $req_fields = array('full-name','username','password','level' );
   validate_fields($req_fields);

   if(empty($errors)){
           $name   = remove_junk($db->escape($_POST['full-name']));
       $username   = remove_junk($db->escape($_POST['username']));
       $password   = remove_junk($db->escape($_POST['password']));
       $user_level = (int)$db->escape($_POST['level']);
       $password = sha1($password);
        $query = "INSERT INTO users (";
        $query .="name,username,password,user_level,status";
        $query .=") VALUES (";
        $query .=" '{$name}', '{$username}', '{$password}', '{$user_level}','1'";
        $query .=")";
        if($db->query($query)){
          //sucess
          $session->msg('s'," Cuenta de usuario ha sido creada");
          redirect('add_user.php', false);
        } else {
          //failed
          $session->msg('d',' No se pudo crear la cuenta.');
          redirect('add_user.php', false);
        }
   } else {
     $session->msg("d", $errors);
      redirect('add_user.php',false);
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

  <div class="panel-control">

         <div class="contenedor-tabla add-user">

           <div class="tabla-encabezado">
             <i class="fas fa-user-check table-icon"></i>
             <p>AGREGAR USUARIO</p>
           </div>
           <div class="form-user">
             <div class="form-add-user">
           <p style="color: #3458C1; text-align: center; margin-left:10px; font-size: 24px;
           ">Llenar Campos</p>
           <form method="post" action="add_user.php">
           <p style="margin-top: 15px; margin-left: 25px;
           color: #3458C1; font-size: 14px;">Nombre</p>
           <input type="text" placeholder="Nombre Completo" class="input-grp size" name="full-name" style="display: block;">
           <p style="margin-left: 25px;
           color: #3458C1; font-size: 14px;">Usuario</p>
           <input type="text" placeholder="Nombre de Usuario" class="input-grp size" name="username" style="display: block;">
           <p style="margin-left: 25px;
           color: #3458C1; font-size: 14px;">Contraseña</p>
           <input type="password" placeholder="Contraseña" class="input-grp size" name="password" style="display: block;">

           <p style="margin-left: 25px;
           color: #3458C1; font-size: 14px;">Rol de Usuario</p>

           <select class="select-st size" name="level" style="display: block;">
              <?php foreach ($groups as $group ):?>
              <option value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
              <?php endforeach;?>
             </select>
           <button style="padding: 10px;
           margin-left: 25px; margin-top: 25px; background: #3458C1; color:#fff;" name="add_user" type="submit">
             Cambiar
           </button>
         </form>
         </div>
           </div>
         </div>

      </div>
  <!--
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Agregar usuario</span>
       </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">
          <form method="post" action="add_user.php">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="full-name" placeholder="Nombre completo" required>
            </div>
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" class="form-control" name="username" placeholder="Nombre de usuario">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name ="password"  placeholder="Contraseña">
            </div>
            <div class="form-group">
              <label for="level">Rol de usuario</label>
                <select class="form-control" name="level">
                  <?php foreach ($groups as $group ):?>
                   <option value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="form-group clearfix">
              <button type="submit" name="add_user" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        </div>

      </div>

    </div>
  </div>-->

<?php include_once('layouts/footer.php'); ?>
