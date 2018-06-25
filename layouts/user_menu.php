<!--MENU IZZQUIERDA-->

     <ul class="menu">
      <li><a href="#">
        <img src="libs/images/ventas.png" width="100px"></a>
      </li>
      <li>
        <a href="home.php"><i class="izq fas fa-home izq"></i>Panel de Control</a>
      </li>
      <li>
           <a href="profile.php?id=<?php echo (int)$user['id'];?>"><i class="izq fas fa-user-circle izq"></i>Perfil</a>
      </li>

      <li>

        <a href="#"><i class="izq fab fa-sellsy izq"></i>Ventas<i class="fas fa-chevron-down der"></i></a>
        <ul>

          <li>
            <a href="#"><i class="izq fas fa-level-down-alt"></i>Administrar Ventas</a>
          </li>

          <li>
            <a href="#"><i class="izq fas fa-level-down-alt"></i>Agregar Venta</a>
          </li>
        </ul>
      </li>
      <li>

        <a href="#"><i class="izq fas fa-chart-line izq"></i>Reporte de Ventas<i class="fas fa-chevron-down der"></i></a>
        <ul>

          <li>
            <a href="sales_report.php"><i class="izq fas fa-level-down-alt"></i>Ventas por fecha</a>
          </li>

          <li>
            <a href="monthly_sales.php"><i class="izq fas fa-level-down-alt"></i>Ventas Mensuales</a>
          </li>
          <li>
            <a href="daily_sales.php"><i class="izq fas fa-level-down-alt"></i>Ventas Diarias</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="edit_account.php"><i class="izq fas fa-cogs izq"></i>Configuracion</a></li>
      <li>
      <li>
        <a href="logout.php"><i class="fas fa-sign-out-alt izq"></i>Salir</a></li>
      <li>
</ul>
<!--
<ul>
  <li>
    <a href="home.php">
      <i class="glyphicon glyphicon-home"></i>
      <span>Panel de control</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-th-list"></i>
       <span>Ventas</span>
      </a>
      <ul class="nav submenu">
         <li><a href="sales.php">Administrar ventas</a> </li>
         <li><a href="add_sale.php">Agregar venta</a> </li>
     </ul>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-signal"></i>
       <span>Reporte de ventas</span>
      </a>
      <ul class="nav submenu">
        <li><a href="sales_report.php">Ventas por fecha </a></li>
        <li><a href="monthly_sales.php">Ventas mensuales</a></li>
        <li><a href="daily_sales.php">Ventas diarias</a> </li>
      </ul>
  </li>
</ul>-->
