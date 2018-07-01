<?php
  $page_title = 'Lista de categorías';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);

  $all_categories = find_all('categories')
?>
<?php
 if(isset($_POST['add_cat'])){
   $req_field = array('categorie-name');
   validate_fields($req_field);
   $cat_name = remove_junk($db->escape($_POST['categorie-name']));
   if(empty($errors)){
      $sql  = "INSERT INTO categories (name)";
      $sql .= " VALUES ('{$cat_name}')";
      if($db->query($sql)){
        $session->msg("s", "Categoría agregada exitosamente.");
        redirect('categorie.php',false);
      } else {
        $session->msg("d", "Lo siento, registro falló");
        redirect('categorie.php',false);
      }
   } else {
     $session->msg("d", $errors);
     redirect('categorie.php',false);
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

<div class="panel-control">

  <div class="contenedor-general">
        <div class="tabla izquier">
          <div class="tabla-encabezado head-cat">
            <i class="fas fa-th table-icon"></i>
              <p>MAS VENDIDOS</p>

          </div>
          <div class="cont-data">
            <form method="post" action="categorie.php">
            <input type="text" name="categorie-name" placeholder="Nombre de la categoria" class="input-categoria">
            <button type="submit" name="add_cat" class="button orange">
            <!--<a href="#">-->
                <span><i class="fas fa-plus-square"></i></span>Agregar categoria
            </button>
            </form>
          </div>

        </div>

        <div class="tabla derech">
           <div class="tabla-encabezado">
            <i class="fas fa-th table-icon"></i>
              <p>LISTA DE CATEGORIAS</p>
          </div>
          <div class="contenedor-tabla">
          <table border="1px" class="tabla-datos">
          <thead>
            <tr>
              <th>#</th>
              <th>Categoria</th>
              <th>Editar</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($all_categories as $cat):?>
               <tr>
                 <td class="text-center"><?php echo count_id();?></td>
                 <td><?php echo remove_junk(ucfirst($cat['name'])); ?></td>
                 <td>
                  <a href="edit_categorie.php?id=<?php echo (int)$cat['id'];?>" class="btn-ico">
                  <span><i class="far fa-edit"></i></span>
                </a>
                </td>
                 <td>
                   <a href="delete_categorie.php?id=<?php echo (int)$cat['id'];?>" class="btn-ico">
                     <span><i class="fas fa-trash-alt"></i></span>
                  </a>
                 </td>
              </tr>
              <?php endforeach; ?>
          </tbody>

        </table>
        </div>
        </div>
      </div>
  </div>


  <?php include_once('layouts/footer.php'); ?>
