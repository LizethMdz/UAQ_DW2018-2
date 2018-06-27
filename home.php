<?php
  $page_title = 'Home Page';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php include_once('layouts/header.php'); ?>

      <div class="contenido">
         <h1>Esta es su página de inicio</h1>
         <img src="libs/images/logo-l.png" alt="">
      </div>

<?php include_once('layouts/footer.php'); ?>
