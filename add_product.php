<?php
  $page_title = 'Agregar producto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
?>
<?php
 if(isset($_POST['add_product'])){
   $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );
   validate_fields($req_fields);
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['product-title']));
     $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
     $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
     $p_buy   = remove_junk($db->escape($_POST['buying-price']));
     $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
     if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
       $media_id = '0';
     } else {
       $media_id = remove_junk($db->escape($_POST['product-photo']));
     }
     $date    = make_date();
     $query  = "INSERT INTO products (";
     $query .=" name,quantity,buy_price,sale_price,categorie_id,media_id,date";
     $query .=") VALUES (";
     $query .=" '{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$p_cat}', '{$media_id}', '{$date}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
     if($db->query($query)){
       $session->msg('s',"Producto agregado exitosamente. ");
       redirect('add_product.php', false);
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('product.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_product.php',false);
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

<!---->
<div class="panel-control" style="background: transparent;">
       <div class="tabla media alt">
         <div class="tabla-encabezado">
           <i class="far fa-plus-square table-icon"></i>
           <p>AGREGAR PRODUCTO</p>
         </div>

         <div class="contenedor-tabla">
           <p style="color:#3458C1 ;  font-size: 14px; margin-left: 25px; display: block;">Nombre del Producto</p>
           <i class="fas fa-th-large icon-pro" style="margin-left: 25px;"></i>
           <input type="text" class="input-product" style="display: inline-block; margin-left: 0px;" name="product-title">
           <p style="color:#3458C1 ; font-size: 14px; margin-left: 25px; display: block;">Categoria</p>
           <select name="product-categorie" class="input-product">
             <option value="">Selecciona una Categoria</option>
             <?php  foreach ($all_categories as $cat): ?>
               <option value="<?php echo (int)$cat['id'] ?>">
                 <?php echo $cat['name'] ?></option>
             <?php endforeach; ?>
           </select>
           <p style="color:#3458C1 ; font-size: 14px; margin-left: 25px; display: block;">Imagen del producto</p>
           <select name="product-photo" id="" class="input-product">
             <option value="">Sin imagen</option>
             <?php  foreach ($all_photo as $photo): ?>
               <option value="<?php echo (int)$photo['id'] ?>">
                 <?php echo $photo['file_name'] ?></option>
             <?php endforeach; ?>
           </select>

           <p style="color:#3458C1 ; font-size: 14px; margin-left: 130px;">Cantidad</p>
           <p style="color:#3458C1 ; font-size: 14px; margin-left:130px;">Precio de Compra</p>
           <p style="color:#3458C1 ; font-size: 14px; margin-left: 140px;">Precio de venta</p>
           <br>
           <i class="fas fa-cart-plus icon-pro" style="margin-left: 25px;"></i>

           <input type="text" name="product-quantity" class="input-product lineal">

           <i class="fas fa-dollar-sign icon-pro"></i>
           <input type="text" class="input-product lineal" name="buying-price">
           <p class="text-icon">.00</p>
           <i class="fas fa-dollar-sign icon-pro"></i>
           <input type="text" class="input-product lineal" name="saleing-price">

            <p class="text-icon">.00</p>

            <button type="submit" name="add_product" class="button bg-success btn-actu">
           <!--<a href="#">-->
               <span><i class="fas fa-pen-square"></i></span>Agregar
           </button>
         </div>
       </div>
    </div>

<?php include_once('layouts/footer.php'); ?>
