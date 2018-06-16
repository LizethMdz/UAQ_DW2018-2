<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>

<?php include_once('layouts/header2.php'); ?>
<div class="fondo"></div>
    <!--Nav-->
  <nav>
    <div class="navbar-top">
      <a class="navbar-title" href="#">SIST-INVENT</a>
    </div>
  </nav>
  
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
              $(".alerta").fadeOut(1500);
            },1000);
        });
  </script>
<?php 
  }
 ?>

</div>
  <section>
    <div class="container">
      <div class="login-form">
        <h1>Iniciar Sesion</h1>
        <img src="libs/images/login.png" alt="Usuario" height="100px" width="100px">
        <form action="auth.php" method="POST">
          <input type="text" name="username" placeholder="Usuario">
          <input type="password" name="password" placeholder="Contraseña">
          <input type="submit" name="Login" value="Login">
        </form>
      </div>
    </div>
  </section>

<?php include_once('layouts/footer.php'); ?>
