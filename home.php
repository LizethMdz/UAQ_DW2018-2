<?php
  $page_title = 'Home Page';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php include_once('layouts/header2.php'); ?>

      <div class="contenido">
         <h1>Esta es su nueva página de inicio</h1>
      </div>

<?php include_once('layouts/footer.php'); ?>
