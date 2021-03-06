
<?php
 $user = current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
	Sistema de Inventario</title>
  <link rel="stylesheet" href="libs/css/estilos.css"/>

    <!--Enlace de los iconos-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
</head>
<body>
	<?php  if ($session->isUserLoggedIn(true)): ?>

      <header id="header">
      <div class="logo"> SIST-INVENT </div>
           <div class="header-date-up">
             <?php date_default_timezone_set("America/Mexico_City"); echo date("d/m/Y  h:i:s");?>
            </div>
             <div class="header-user">

                <img src="uploads/users/<?php echo $user['image'];?>" alt="user-image"class="img-user">

                  <a href="profile.php?id=<?php echo (int)$user['id'];?>" class="header-user-name">
                    <?php echo $user['name']; ?>
                  </a>


            </div>

      </header>


  <div class="contenedor-menu">
      <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
      <?php include_once('admin_menu.php');?>

    <?php elseif($user['user_level'] === '2'): ?>
      <!-- Special user -->
    <?php include_once('user_menu.php');?>

    <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
      <?php include_once('user_menu.php');?>

      <?php endif;?>

   </div>
<?php endif;?>
