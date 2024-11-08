
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- main -->
  <link rel="stylesheet" href="../public/css/main.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/css/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
  <!-- Alertas style -->
  <link rel="stylesheet" href="../public/css/sweetalert2.css">
  <!-- selt2 -->
  <link rel="stylesheet" href="../public/css/select2.css">
  <!-- Seccion compras -->
  <link rel="stylesheet" href="../public/css/compra.css">
  <!-- Datatable -->
  <link rel="stylesheet" href="../public/css/datatables.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

<!-- **************************************************** -->
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>

      <li id="cat-carrito" class="nav-item dropdown" style="display:none">
        <a class="tx-carrito nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Carrito
        </a>
        <span id="contador" class="contador badge badge-danger"></span>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <table class="carro table table-over text-nowrap p-0">
            <thead class="table-success">
              <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Concentración</th>
                <th>Adicional</th>
                <th>Precio</th>
                <th>Eliminar</th>

              </tr>
            </thead>
            <tbody id="tbd-lista"></tbody>
          </table>
          <a href="#" id="procesar-pedido" class="btn btn-danger btn-block">Procesar compra</a>
          <a href="#" id="vaciar-carrito" class="btn btn-primary btn-block">Vaciar Carrito</a>

        </div>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <a href="../controllers/logout.php">Cerrar</a>
   
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <!-- *************************************************** -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <!-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light">Software Xime28</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        </div>
        <div class="info">
          <!-- <a href="adm_cat.php" class="d-block"><?php echo $_SESSION['nom'];?></a> -->
          <a href="adm_cat.php" class="d-block">Nueva Venta</a>
        </div>
      </div>

     

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-header">Usuario</li>
          <!-- items que contiene la seccion Ventas -->
          <li class="nav-item">
            <a href="editar_perfil.php" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Mi Perfil
              </p>
            </a>
          </li>

          <?php if($_SESSION['rol'] == 1){?>
          <li class="nav-item">
            <a href="adm_usuario.php" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Gestión de Usuarios
              </p>
            </a>
          </li>

          <?php }?>

       
          <li class="nav-header">Almacen</li>
          <li class="nav-item">
            <a href="adm_product.php" class="nav-link">
              <i class="nav-icon fas fa-pills"></i>
              <p>
                Gestión de productos
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="adm_atr.php" class="nav-link">
              <i class="nav-icon fas fa-vials"></i>
              <p>
                Gestión de Atributos
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="adm_lote.php" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
                Gestión de Lotes
              </p>
            </a>
          </li>

          <li class="nav-header">Compras</li>
          <li class="nav-item">
            <a href="adm_proveed.php" class="nav-link">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Compras a proveedores
              </p>
            </a>
          </li>

          <?php if($_SESSION['rol'] == 1){?>
          <li class="nav-header">Ventas</li>
          <!-- items que contiene la seccion Ventas -->
          <li class="nav-item">
            <a href="adm_venta.php" class="nav-link">
              <i class="nav-icon fas fa-notes-medical"></i>
              <p>
                Gestión de Ventas
              </p>
            </a>
          </li>
          <?php }elseif($_SESSION['rol'] == 2){?>
            <!-- MOMENTANEO: REDIRIGIR A OTRA VISTA QUE NO TIENE EL BOTON ELIMINAR VENTA -->
            <li class="nav-header">Ventas</li>
          <!-- items que contiene la seccion Ventas -->
          <li class="nav-item">
            <a href="adm_venta2.php" class="nav-link">
              <i class="nav-icon fas fa-notes-medical"></i>
              <p>
                Gestión de Ventas2
              </p>
            </a>
          </li>
          <?php } ?>



        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>