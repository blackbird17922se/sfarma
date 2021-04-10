<?php
session_start();
if(!empty($_SESSION['rol']==1 || $_SESSION['rol']==2)){
    include_once "layouts/header.php";
    include_once "layouts/nav.php";
?>

<!-- modal producto -->
<div class="modal fade" id="crearproveed" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Crear Proveedor</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">

                <!-- ALERTAS -->
                    <div class="alert alert-success text-center" id="add-proveed" style="display: none;">
                        <span><i class="fas fa-check m-1"></i>Registro Exitoso</span>
                    </div>

                    <div class="alert alert-danger text-center" id="noadd-proveed" style="display: none;">
                        <span><i class="fas fa-times m-1"></i>Ya existe el proveedor ingresado</span>
                    </div>

                    <div class="alert alert-success text-center" id="edit-proveed" style="display: none;">
                        <span><i class="fas fa-check m-1"></i>Proveedor editado</span>
                    </div>


                    <!-- FORMULARIO -->
                    <form action="" id="form-crear-proveed">
                        <!-- <div class="form-group">
                            <label for="id_prov">NIT del proveedor</label>
                            <input type="text" class="form-control" id="id_prov" name="id_prov" aria-describedby="id_provHelp" required>
                        </div> -->

                        <div class="form-group">
                            <label for="nom">Nombre del proveedor</label>
                            <input type="text" class="form-control" id="nom" name="nom" aria-describedby="nomHelp" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="telef">Teléfono de contacto</label>
                            <input type="number" class="form-control" id="telef" name="telef" aria-describedby="telefHelp">
                        </div>

                        <div class="form-group">
                            <label for="correo">Correo electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" aria-describedby="correoHelp">
                            <small id="correoHelp" class="form-text text-muted">Correo electrónico del proveedor.</small>
                        </div>

                        <div class="form-group">
                            <label for="direc">Dirección del proveedor</label>
                            <input type="text" class="form-control" id="direc" name="direc" aria-describedby="direcHelp">
                        </div>
                     
                        <input type="hidden" id="id_edit_proveed">

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
            <h1>Gestión de Proveedores
                <button id="btn-crear" type="button" data-toggle="modal" data-target="#crearproveed" class="btn bg-gradient-primary ml-2" title="editar">Crear Proveedor</button>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">gestión de proveedores</li>
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
                    <h3 class="card-title">Buscar Proveedor</h3>
                    <div class="input-group">
                        <input id="buscar-proveed" type="text" class="form-control float-left" placeholder="Ingrese el nombre del proveedor">
                        <div class="input-group-append">
                            <buttom class="btn btn-default"><i class="fas fa-search"></i></buttom>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="cb-proveed" class="row d-flex align-items-stretch">

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
<script src="../public/js/proveed.js"></script>
<!-- <script src="../public/js/laboratorio.js"></script>
<script src="../public/js/tipo.js"></script>
<script src="../public/js/presentacion.js"></script> -->