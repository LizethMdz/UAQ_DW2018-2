<?php
  $page_title = 'Mi perfil';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
  <?php
  $user_id = (int)$_GET['id'];
  if(empty($user_id)):
    redirect('home.php',false);
  else:
    $user_p = find_by_id('users',$user_id);
  endif;
?>
<?php include_once('layouts/header2.php'); ?>
<div class="panel-control" style="background:#F1F2F7;">

      <div class="contenedor-perfil">
             <div class="img-perfil">
               <img src="uploads/users/<?php echo $user_p['image'];?>" alt="user" width="100px" height="100px" style="margin-left: 35%;
               margin-top: 5%; border-radius: 50%;">
               <small style="padding: 20px; left:30%; top:120px; position: absolute;
               color: white;"><?php echo first_character($user_p['name']); ?></small>
               <div class="text-perfil">
                <?php if( $user_p['id'] === $user['id']):?>
               <a href="edit_account.php" class="icon-perfil">
                 <i class="fas fa-user-edit"></i>
                 <small>Editar</small>
               </a>
               <?php endif;?>
             </div>
             </div>

      </div>
</div>
<!--
<div class="row">
   <div class="col-md-4">
       <div class="panel profile">
         <div class="jumbotron text-center bg-red">
            <img class="img-circle img-size-2" src="uploads/users/<?php echo $user_p['image'];?>" alt="">
           <h3><?php echo first_character($user_p['name']); ?></h3>
         </div>
        <?php if( $user_p['id'] === $user['id']):?>
         <ul class="nav nav-pills nav-stacked">
          <li><a href="edit_account.php"> <i class="glyphicon glyphicon-edit"></i> Editar perfil</a></li>
         </ul>
       <?php endif;?>
       </div>
   </div>
</div>-->
<?php include_once('layouts/footer.php'); ?>
