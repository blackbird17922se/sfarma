$(document).ready(function(){
    var funcion;
    var edit = false;

    /* buscara los campos de lista desplegable con la clase select2 + la funcion interna select2*/
    $('.select2').select2();
    buscarUsuario();


    /* Funciones para llenar las listad desplegables */
    listarRoles();
    function listarRoles(){
        funcion = "listarRoles";
        $.post('../controllers/usuarioController.php',{funcion},(response)=>{
            // console.log(response);
            const ROLES = JSON.parse(response);
            let template = '';
            ROLES.forEach(usuario=>{
                template+=`
                    <option value="${usuario.id_rol}">${usuario.nom_rol}</option>
                `;
            });
            /* id del campo que contiene el listado */
            $('#rol').html(template);
        })
    }
    

    /* CREAR USUARIO */
    $('#form-crear-usuario').submit(e=>{
        /* recibir los datos del formulario al hacer click en el boton submit */
        /* val(): obtiene el valor en el imput */
        let nom = $('#nom').val();
        let ape = $('#ape').val();
        let dni_us = $('#dni_us').val();
        let contras = $('#contras').val();
        let rol = $('#rol').val();

        console.log(nom+" "+ape+" "+dni_us+" "+contras+" "+rol);
        if(edit==true){
            funcion="editarUsuario";
        }else{
            funcion="crearUsuario";
        }
        // funcion = "crear";
        $.post('../controllers/usuarioController.php',{funcion,nom,ape,dni_us,contras,rol},(response)=>{
            console.log(response);

            if(response=='add'){
                $('#add-usuario').hide('slow');
                $('#add-usuario').show(1000);
                $('#add-usuario').hide(2000);
                $('#form-crear-usuario').trigger('reset');
                buscarUsuario();
            }
            if(response=='edit'){
                $('#edit-usuario').hide('slow');
                $('#edit-usuario').show(1000);
                $('#edit-usuario').hide(2000);
                $('#form-crear-usuario').trigger('reset');
                buscarUsuario();
            }
            if(response=='noadd'){
                $('#noadd-usuario').hide('slow');
                $('#noadd-usuario').show(1000);
                $('#noadd-usuario').hide(2000);
                $('#form-crear-usuario').trigger('reset');
            }
            if(response=='noedit'){
                $('#noadd-usuario').hide('slow');
                $('#noadd-usuario').show(1000);
                $('#noadd-usuario').hide(2000);
                $('#form-crear-usuario').trigger('reset');
            }
            edit = false;
        })
        e.preventDefault();
    });


    /* BUSCAR USUARIO */
    function buscarUsuario(consulta){
        funcion = 'cargarUsuarios';

        $.post('../controllers/usuarioController.php',{consulta,funcion},(response)=>{
            // console.log(response);

            const USUARIOS = JSON.parse(response);
            let template = '';
            USUARIOS.forEach(usuario=>{
                // <div usuId="${usuario.id_usu}" usuNom="${usuario.nom}" usuApe="${usuario.ape}" usuDNI="${usuario.dni_us}" usuContras="${usuario.contras}" usuRol="${usuario.rol}" class="col-12 col-sm-6 col-md-4 align-items-stretch">

                template+=`
                    <div usuId="${usuario.id_usu}" usuNom="${usuario.nom}" class="col-12 col-sm-6 col-md-4 align-items-stretch">

                        <div class="card bg-light">
                            <div class="card-header text-muted border-bottom-0">
                            ${usuario.rol}
                        </div>

                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="lead"><b> ${usuario.nom}  ${usuario.ape}</b></h2>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-id-card"></i></span>Número Identificador: ${usuario.dni_us} </li>                             
                                    </ul>
                                </div>
                            </div>
                        </div>

                        
                        <div class="card-footer">
                            <div class="text-right">
                            
                                <button class="borrar btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
             
                `;
            });

            $('#cb-usuarios').html(template);
        })
    }


    /* BUSQUEDAS EN EL CAMPO BUSCAR */
    $(document).on('keyup','#buscar-usuario',function(){
        let valor = $(this).val();
        if(valor != ''){
            buscarUsuario(valor);
        }else{
            buscarUsuario();
        }
    });


    /* ELIMINAR USUARIO */
    $(document).on('click','.borrar',(e)=>{
        var funcion = "borrar";
        const ELEM = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const ID = $(ELEM).attr('usuId');
        const NOMB = $(ELEM).attr('usuNom');
        // console.log(ID + NOMB);

        // Alerta

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-1'
            },
            buttonsStyling: false
          })
          
          swalWithBootstrapButtons.fire({
            title: '¿Está seguro que desea eliminar el usuario '+NOMB+'?',
            text: "Esta acción ya no se podrá deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                $.post('../controllers/usuarioController.php',{ID,funcion},(response)=>{
                    // console.log(response);
                    edit==false;
                    if(response=='borrado'){
                        swalWithBootstrapButtons.fire(
                            'Eliminado '+NOMB+'!',
                            'El usuario ha sido eliminado.',
                            'success'
                        )
                        buscarUsuario();
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error al eliminar '+NOMB,
                            'No se pudo eliminar el usuario.',
                            'error'
                        )
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
 
            }
          })
    });


})