<?php
session_start();
if(!empty($_SESSION['rol']==2)){
    include_once "layouts/header.php";
    include_once "layouts/nav.php";
?>

<!-- modal lote -->
<div class="modal fade" id="vista-venta" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Registros de venta</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="codigo_venta">Codigo Venta: </label>
                        <span id="codigo_venta"></span>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha: </label>
                        <span id="fecha"></span>
                    </div>
                    <div class="form-group">
                        <label for="cliente">Cliente: </label>
                        <span id="cliente"></span>
                    </div>
                    <div class="form-group">
                        <label for="vendedor">Vendedor: </label>
                        <span id="vendedor"></span>
                    </div>

                    <table class="table table-hover text-nowrap">
                        <thead class="table-success">
                            <tr>
                                <th>Cantidad</th>
                                <th>Precio Unidad</th>
                                <th>Producto</th>
                                <th>Concentracion</th>
                                <th>Adicional</th>
                                <th>Laboratorio</th>
                                <th>Presentacion</th>
                                <th>Tipo</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="registros" class="table-warning">

                        </tbody>
                    </table>
                    <div class="float-right input-group-append">
                        <h3 class="m-3">Total: </h3>
                        <h3 class="m-3" id="total"></h3>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right m-1">Cerrar</button>
                    
                </div>
            </div>
        </div>
    </div>
</div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestión de Ventas
                <!-- <button id="btn-crear" type="button" data-toggle="modal" data-target="#crearlote" class="btn bg-gradient-primary ml-2" title="editar">Crear Producto</button> -->
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">gestión de Ventas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section>
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Buscar venta</h3>
                </div>

                <div class="card-body">
                    <table id="tabla_venta" class="display table table-hover text-nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Vendedor</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Extn.</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr> -->
                        </tbody>
                    </table>              
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

 <script src="../public/js/datatables.js"></script>
<script src="../public/js/venta2.js"></script>