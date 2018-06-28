<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>

<?php
 // Auto suggetion
    $html = '';
   if(isset($_POST['product_name']) && strlen($_POST['product_name']))
   {
     $products = find_product_by_title($_POST['product_name']);

     if($products){
        foreach ($products as $product):
           $html .= "<h4 class=\"list-group-item\">";
           $html .= $product['name'];
           $html .= "</h4>";
         endforeach;
      } else {

        $html .= '<h4 class=\"list-group-item\">';
        $html .= 'No encontrado';
        $html .= "</h4>"; /*li*/

      }

      echo json_encode($html);
   }
 ?>
 <?php
 // find all product
  if(isset($_POST['p_name']) && strlen($_POST['p_name']))
  {
    $product_title = remove_junk($db->escape($_POST['p_name']));
    if($results = find_all_product_info_by_title($product_title)){
        foreach ($results as $result) {

          $html .= "<tr>";

          $html .= "<td id=\"s_name\">".$result['name']."</td>";
          $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$result['id']}\">";
          $html  .= "<td>";
          $html  .= "<input type=\"text\" name=\"price\" value=\"{$result['sale_price']}\">";
          $html  .= "</td>";
          $html .= "<td id=\"s_qty\">";
          $html .= "<input type=\"text\" name=\"quantity\" value=\"1\">";
          $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<input type=\"text\" name=\"total\" value=\"{$result['sale_price']}\">";
          $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<input type=\"date\" name=\"date\" data-date-format=\"yyyy-mm-dd\">";
          $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<button type=\"submit\" name=\"add_sale\" class=\"btn-agregar\">Agregar</button>";
          $html  .= "</td>";
          $html  .= "</tr>";

        }
    } else {
        $html ='<tr><td colspan="6">El producto no se encuentra registrado en la base de datos</td></tr>';
    }

    echo json_encode($html);
  }
 ?>
