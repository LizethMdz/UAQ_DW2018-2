<?php
  $page_title = 'Editar producto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product = find_by_id('products',(int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if(!$product){
  $session->msg("d","Missing product id.");
  redirect('product.php');
}
?>
<?php
 if(isset($_POST['product'])){
    $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );
    validate_fields($req_fields);

   if(empty($errors)){
       $p_name  = remove_junk($db->escape($_POST['product-title']));
       $p_cat   = (int)$_POST['product-categorie'];
       $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
       $p_buy   = remove_junk($db->escape($_POST['buying-price']));
       $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['product-photo']));
       }
       $query   = "UPDATE products SET";
       $query  .=" name ='{$p_name}', quantity ='{$p_qty}',";
       $query  .=" buy_price ='{$p_buy}', sale_price ='{$p_sale}', categorie_id ='{$p_cat}',media_id='{$media_id}'";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Producto ha sido actualizado. ");
                 redirect('product.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('edit_product.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
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

<div class="panel-control" style="background: transparent;">
        <div class="tabla media alt">
          <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
          <div class="tabla-encabezado">
            <i class="far fa-edit table-icon"></i>
            <p>EDITAR PRODUCTO</p>
          </div>

          <div class="contenedor-tabla">
            <p style="color:#3458C1 ;  font-size: 14px; margin-left: 25px; display: block;">Nombre del Producto</p>
            <i class="fas fa-th-large icon-pro" style="margin-left: 25px;"></i>
            <input type="text" class="input-product" style="display: inline-block; margin-left: 0px;"
            name="product-title" value="<?php echo remove_junk($product['name']);?>">
            <p style="color:#3458C1 ; font-size: 14px; margin-left: 25px; display: block;">Categoria</p>
            <select name="product-categorie"  class="input-product">
              <option value="">Selecciona una Categoria</option>
              <?php  foreach ($all_categories as $cat): ?>
              <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['categorie_id'] === $cat['id']): echo "selected"; endif; ?> >
                  <?php echo remove_junk($cat['name']); ?></option>
              <?php endforeach; ?>
            </select>
            <p style="color:#3458C1 ; font-size: 14px; margin-left: 25px; display: block;">Imagen del producto</p>
            <select name="product-photo" class="input-product">
              <option value="">Sin imagen</option>
              <?php  foreach ($all_photo as $photo): ?>
                <option value="<?php echo (int)$photo['id'];?>" <?php if($product['media_id'] === $photo['id']): echo "selected"; endif; ?> >
                  <?php echo $photo['file_name'] ?></option>
              <?php endforeach; ?>
            </select>

            <p style="color:#3458C1 ; font-size: 14px; margin-left: 130px;">Cantidad</p>
            <p style="color:#3458C1 ; font-size: 14px; margin-left:130px;">Precio de Compra</p>
            <p style="color:#3458C1 ; font-size: 14px; margin-left: 140px;">Precio de venta</p>
            <br>
            <i class="fas fa-cart-plus icon-pro" style="margin-left: 25px;"></i>

            <input type="text" class="input-product lineal" name="product-quantity" value="<?php echo remove_junk($product['quantity']); ?>">

            <i class="fas fa-dollar-sign icon-pro"></i>
            <input type="number" class="input-product lineal" name="buying-price" value="<?php echo remove_junk($product['buy_price']);?>">
            <p class="text-icon">.00</p>
            <i class="fas fa-dollar-sign icon-pro"></i>
            <input type="text" class="input-product lineal" name="saleing-price" value="<?php echo remove_junk($product['sale_price']);?>">

             <p class="text-icon">.00</p>

             <button type="submit" name="product" class="button bg-success btn-actu">
            <!--<a href="#">-->
                <span><i class="fas fa-pen-square"></i></span>Actualizar
            </button>
          </form>
          </div>
        </div>
     </div>


<?php include_once('layouts/footer.php'); ?>
