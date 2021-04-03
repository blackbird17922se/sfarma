<?php
session_start();
if(!empty($_SESSION['rol']==1 || $_SESSION['rol']==2)){
    include_once "layouts/header.php";
    include_once "layouts/nav.php";
?>

<!-- modal lote -->
<div class="modal fade" id="cambioContras" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Cambiar Contraseña</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">

                    <!-- ALERTAS -->
                    <div class="alert alert-success text-center" id="edit-contras" style="display: none;">
                        <span><i class="fas fa-check m-1"></i>Contraseña Actualizada</span>
                    </div>

                    <div class="alert alert-danger text-center" id="noedit-contras" style="display: none;">
                        <span><i class="fas fa-times m-1"></i>Contraseña Incorrecta</span>
                    </div>


                    <!-- FORMULARIO -->
                    <div class="text-center">
                        <b>
                            <h3>Usuario: 
                                <?php
                                    echo $_SESSION['nom'];
                                ?>
                            </h3>
                        </b>
                    </div>

                    <form id="form-pass" autocomplete="off">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-unlock-alt"></i>
                                </span>
                            </div>
                            <input id="oldpass" type="password" class="form-control" placeholder="Ingrese Contraseña Actual" required>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            <input id="newpass" type="text" class="form-control" placeholder="Ingrese Contraseña Nueva" required>
                        </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn bg-gradient-primary mr-2">Guardar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary">Cerrar</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>  <!-- Fin Modal -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perfil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Perfil</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-success card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">

                                <input type="hidden" id="id_usu" value="<?php echo $_SESSION['usuario'];?>">
                                
                                <h3 id="nom" class="profile-username text-center text-success"></h3>
                                <p id="ape" class="text-muted text-center"></p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b style="color: #0B7300">C.C: </b>
                                        <a id="dni_us" href="#" class="float-right"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b style="color: #0B7300">Rol: </b>
                                        <span id="rol" class="float-right badge badge-primary"></span>
                                    </li>

                                    <!-- Boton Cambiar Contraseña -->
                                    <button data-toggle="modal" data-target="#cambioContras" type="button" class="btn btn-block btn-outline-warning btn-sm">Cambiar Mi Contraseña</button>
                               
                                </ul>
                                <!-- Boton Editar Datos -->
                                <button class="edit btn btn-block bg-gradient-danger">Editar</button>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Editar Perfil</h3>
                        </div>

                        <div class="card-body">
                            <div class="alert alert-success text-center" id="editado" style="display: none;">
                                <span><i class="fas fa-check m-1"></i>Editado</span>
                            </div>

                            <div class="alert alert-danger text-center" id="noeditado" style="display: none;">
                                <span><i class="fas fa-times m-1"></i>Has clic primero en el botón Editar</span>
                            </div>



                            <form id="form-usuario" class="form-horizontal">
                                <div class="form-group row">
                                    <label for="c_nom" class="col-sm-2 col-form-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="c_nom" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="c_ape" class="col-sm-2 col-form-label">Apellido</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="c_ape" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10 float-right">
                                        <button class="btn btn-block btn-outline-success">Guardar</button>
                                    </div>
                                </div>
                     
                            </form>

                        </div>

                        <div class="card-footer">
                            <!-- </form> -->

                        </div>
                    </div>
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

<script src="../public/js/usuario.js"></script>
