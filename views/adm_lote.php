<?php
session_start();
if(!empty($_SESSION['rol']==1)){
    include_once "layouts/header.php";
    include_once "layouts/nav.php";
?>

<!-- modal lote -->
<div class="modal fade" id="editarlote" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Editar lote</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">

                    <!-- ALERTAS -->
                    <div class="alert alert-success text-center" id="edit-lote" style="display: none;">
                        <span><i class="fas fa-check m-1"></i>Modificacion Exitosa</span>
                    </div>

                    <div class="alert alert-danger text-center" id="noedit-lote" style="display: none;">
                        <span><i class="fas fa-times m-1"></i>No se pudo editar</span>
                    </div>


                    <!-- FORMULARIO -->
                    <form id="form-editar-lote">

                        <div class="form-group">
                            <label for="id_lote">Codigo lote:</label>
                            <label id="id_lote">NombreX</label>
                        </div>


                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="text" class="form-control" id="stock" name="stock" aria-describedby="stockHelp" required>
                        </div>
                        
   <!--                      <div class="form-group">
                            <label for="vencim">Fecha de vencimiento</label>
                            <input type="date" class="form-control" id="vencim" name="vencim" aria-describedby="vencimHelp">
                        </div> -->
    
                        <input type="hidden" id="lote_id_prod">

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right m-1">Cerrar</button>
                    </form>
                    
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
            <h1>Gestión de lotes
                <!-- <button id="btn-crear" type="button" data-toggle="modal" data-target="#crearlote" class="btn bg-gradient-primary ml-2" title="editar">Crear Producto</button> -->
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">gestión de lotes</li>
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
                    <h3 class="card-title">Buscar lote</h3>
                    <div class="input-group">
                        <input id="buscar-lote" type="text" class="form-control float-left" placeholder="Ingrese el nombre del producto">
                        <div class="input-group-append">
                            <buttom class="btn btn-default"><i class="fas fa-search"></i></buttom>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="cb-lotes" class="row d-flex align-items-stretch">

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
<script src="../public/js/lote.js"></script>
<!-- <script src="../public/js/laboratorio.js"></script>
<script src="../public/js/tipo.js"></script>
<script src="../public/js/presentacion.js"></script> -->