<?php
session_start();
if(!empty($_SESSION['rol']==1)){
    include_once "layouts/header.php";
    include_once "layouts/nav.php";

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Catalogo</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section>
        <div class="container-fluid">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Lotes en riesgo</h3>
                    
                </div>

                <div class="card-body p-0 table-responsive">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>Cod.</th>
                        <th>Producto</th>
                        <th>Stock</th>
                        <th>Laboratorio</th>
                        <th>Presentación</th>
                        <th>Proveedor</th>
                        <th>Mes</th>
                        <th>Dia</th>
                      </tr>
                    </thead>

                    <tbody id="tbd-lotes" class="table-active">
                      
                    </tbody>
                  </table>
                 
            
                </div>

                <div class="card-footer">
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Buscar producto</h3>
                    <div class="input-group">
                        <input id="buscar-product" type="text" class="form-control float-left" placeholder="Ingrese el nombre del producto">
                        <div class="input-group-append">
                            <buttom class="btn btn-default"><i class="fas fa-search"></i></buttom>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="cb-products" class="row d-flex align-items-stretch">

                    </div> 
                </div>

                <div class="card-footer">
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  


<?php
include_once "layouts/footer.php";

}else{
    // session_destroy();
    header("Location: ../index.php");
}
?>
<script src="../public/js/catalogo.js"></script>
<script src="../public/js/carrito.js"></script>
