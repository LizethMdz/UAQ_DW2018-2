<?php
  $page_title = 'Admin página de inicio';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
 $c_categorie     = count_by_id('categories');
 $c_product       = count_by_id('products');
 $c_sale          = count_by_id('sales');
 $c_user          = count_by_id('users');
 $products_sold   = find_higest_saleing_product('10');
 $recent_products = find_recent_product_added('5');
 $recent_sales    = find_recent_sale_added('5')
?>
<?php include_once('layouts/header.php'); ?>


      <div class="panel-control">
        <article class="full-width tile">
        <div class="tile-text">
          <span class="text-condensedLight" style="color: #A3C86D;">
            <?php  echo $c_user['total']; ?><br>
            <small>Administradores</small>
          </span>
          <div class="overlay-p">
              <div class="text-p">Administradores</div>
          </div>
        </div>
        <div class="tile-icon bg-success">
            <i class="fas fa-users tile-icon-int"></i>
        </div>
      </article>

      <article class="full-width tile">
        <div class="tile-text">
          <span class="text-condensedLight" style="color: #FF7857;">
            <?php  echo $c_categorie['total']; ?><br>
            <small>Categorias</small>
          </span>
          <div class="overlay-p">
              <div class="text-p">Categorias</div>
          </div>
        </div>
        <div class="tile-icon bg-danger">
            <i class="fab fa-elementor tile-icon-int "></i>
        </div>
      </article>
      <article class="full-width tile">
        <div class="tile-text">
          <span class="text-condensedLight" style="color: #7ACBEE;">
            <?php  echo $c_product['total']; ?><br>
            <small>Productos</small>
          </span>
          <div class="overlay-p">
              <div class="text-p">Productos</div>
          </div>
        </div>
         <div class="tile-icon bg-info">
            <i class="fab fa-product-hunt tile-icon-int "></i>
          </div>
      </article>
      <article class="full-width tile">
        <div class="tile-text">
          <span class="text-condensedLight" style="color: #FDD761;">
            <?php  echo $c_sale['total']; ?><br>
            <small>Ventas</small>
          </span>
          <div class="overlay-p">
              <div class="text-p">Ventas</div>
          </div>
        </div>
          <div class="tile-icon bg-yellow">
            <i class="fab fa-sellsy tile-icon-int"></i>
          </div>
      </article>

      <!--TABLAS-->

      <div class="contenedor-general">
        <div class="tabla">
          <div class="tabla-encabezado">
            <i class="fas fa-th table-icon"></i>
              <p>MAS VENDIDOS</p>

          </div>
          <div class="contenedor-tabla">
          <table border="1px" class="tabla-datos">
          <thead>
            <tr>
              <th>Titulo</th>
              <th>Total vendido</th>
              <th>Cantidad</th>
            </tr>
          </thead>
            <tbody>
            <?php foreach ($products_sold as  $product_sold): ?>
              <tr>
                <td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>
                <td><?php echo (int)$product_sold['totalSold']; ?></td>
                <td><?php echo (int)$product_sold['totalQty']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
          </div>

        </div>
        <div class="tabla ">
           <div class="tabla-encabezado">
            <i class="fas fa-th table-icon"></i>
              <p>ULTIMAS VENTAS</p>
          </div>
          <div class="contenedor-tabla">
          <table border="1px" class="tabla-datos">
          <thead>
            <tr>
              <th>#</th>
              <th>Producto</th>
              <th>Fecha</th>
              <th>Venta Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php foreach ($recent_sales as  $recent_sale): ?>
         <tr>
           <td class="text-center"><?php echo count_id();?></td>
           <td>
            <a href="edit_sale.php?id=<?php echo (int)$recent_sale['id']; ?>">
             <?php echo remove_junk(first_character($recent_sale['name'])); ?>
           </a>
           </td>
           <td><?php echo remove_junk(ucfirst($recent_sale['date'])); ?></td>
           <td>$<?php echo remove_junk(first_character($recent_sale['price'])); ?></td>
        </tr>

       <?php endforeach; ?>
            </tr>
          </tbody>

        </table>
          </div>
        </div>
        <div class="tabla">
           <div class="tabla-encabezado">
            <i class="fas fa-th table-icon"></i>
              <p>PRODUCTOS RECIENTES</p>
          </div>
          <div class="contenedor-tabla">
          <table border="1px" class="tabla-datos">
          <thead>
            <tr>
              <th>Imagen</th>
              <th>Nombre</th>
              <th>Precio</th>
            </tr>
          </thead>
          <?php foreach ($recent_products as  $recent_product): ?>

            <tr>
              <td style="background:#c2f1ff ;">
                <a href="edit_product.php?id=<?php echo(int)$recent_product['id'];?>">
                  <?php if($recent_product['media_id'] === '0'): ?>
                        <img class="img-avatar" src="uploads/products/no_image.jpg" alt="">
                      <?php else: ?>
                       <img class="img-avatar" src="uploads/products/<?php echo $recent_product['image'];?>" alt="" />
                  <?php endif;?>
                </a>
              </td>

              <td><?php echo remove_junk(first_character($recent_product['name']));?></td>
              <td>$ <?php echo (int)$recent_product['sale_price']; ?></td>
            </tr>


          <?php endforeach; ?>
        </table>
          </div>
        </div>

      </div>

      </div>




<?php include_once('layouts/footer.php'); ?>
