<?php
  $page_title = 'Lista de imagenes';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php $media_files = find_all('media');?>
<?php
  if(isset($_POST['submit'])) {
  $photo = new Media();
  $photo->upload($_FILES['file_upload']);
    if($photo->process_media()){
        $session->msg('s','Imagen subida al servidor.');
        redirect('media.php');
    } else{
      $session->msg('d',join($photo->errors));
      redirect('media.php');
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
              $(".alerta").fadeOut(1500);
            },1000);
        });
  </script>
<?php
  }
 ?>

</div>
<div class="panel-control">

      <div class="tabla media">
                 <div class="tabla-encabezado">
                   <form action="media.php" method="POST" enctype="multipart/form-data">
                  <i class="fas fa-camera table-icon"></i>
                  <p>LISTA DE IMAGENES</p>
                    <input type="file" class="input-media" name="file_upload"  multiple="multiple" >

                    <button type="submit" class="btn-enviar" name="submit" class="btn btn-default">
                     Enviar<i class="fas fa-upload table-icon" style="color:#fff;"></i></button>
                  </form>

                </div>

                <div class="contenedor-tabla">
                   <?php foreach ($media_files as $media_file): ?>

                        <div class="contenedor-prod">
                          <div class="image-prod">
                            <img src="uploads/products/<?php echo $media_file['file_name'];?>" style="width:100%; height:150px; display: block;" >
                            <div class="overlay-prod">
                                <div class="text-prod"><?php echo $media_file['file_name'];?></div>
                            </div>
                          </div>
                            <div class="texto-prod" >
                              <a href="delete_media.php?id=<?php echo (int) $media_file['id'];?>" class="icon-prod">
                                <i class="fas fa-trash-alt"></i>
                                <small>Elimimar</small>
                              </a>
                                <br>
                                <small class="sub-texto">ID:<?php echo count_id();?></small>
                                <br>
                                <small class="sub-texto">Tipo: <?php echo $media_file['file_type'];?></small>

                            </div>

                         </div>
                      <?php endforeach;?>
                </div>
      </div>

  </div>

<?php include_once('layouts/footer.php'); ?>
