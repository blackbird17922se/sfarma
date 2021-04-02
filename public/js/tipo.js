$(document).ready(function(){

    buscar_tipo();

    var funcion;
    var edit = false;   // bandera

    /* Formukario crear editar */
    $('#form-crear-tipo').submit(e=>{
        let nom_tipo = $('#nom_tipo').val();
        let id_editado = $('#id_edit_tipo').val();

        if(edit==false){
            funcion="crear";
        }else{
            funcion="editar";
        }

        // funcion = 'crear';
        $.post('../controllers/tipoController.php',{nom_tipo,id_editado,funcion},(response)=>{
            console.log(response)
            if(response=='add'){
                $('#add-tipo').hide('slow');
                $('#add-tipo').show(1000);
                $('#add-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_tipo();
            }
            if(response=='noadd'){
                $('#noadd-tipo').hide('slow');
                $('#noadd-tipo').show(1000);
                $('#noadd-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
            }
            if(response=='edit'){
                $('#edit-tipo').hide('slow');
                $('#edit-tipo').show(1000);
                $('#edit-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_tipo();
            }
            edit=false;
        });
        e.preventDefault();
    });

    function buscar_tipo(consulta){
        funcion = 'buscar';
        // ajax
        $.post('../controllers/tipoController.php',{consulta,funcion},(response)=>{
            // console.log(response);
            const TIPOS = JSON.parse(response);
            let template = '';
            TIPOS.forEach(tipo=>{
                template+=`
                <tr tipoId="${tipo.id_tipo_prod}" tipoNom="${tipo.nom}">
                    <td>${tipo.nom}</td>
                    <td>
                        <button class="editar-tipo btn btn-success" title="editar" type="button" data-toggle="modal" data-target="#creartipo">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
    
                        <button class="borrar-tipo btn btn-danger" title="borrar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                `;
            });
            $('#tbd-tipos').html(template);
        })
    }
    // evento paara las busquedad
    $(document).on('keyup','#busq-tipo',function(){
        let valor = $(this).val();
        if(valor != ''){
            buscar_tipo(valor);
        }else{
            buscar_tipo();
        }
    });

    $(document).on('click','.borrar-tipo',(e)=>{
        var funcion = "borrar";
        const ELEM = $(this)[0].activeElement.parentElement.parentElement;
        const ID = $(ELEM).attr('tipoId');
        const NOMB = $(ELEM).attr('tipoNom');
        console.log(ID + NOMB);

        // Alerta

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-1'
            },
            buttonsStyling: false
          })
          
          swalWithBootstrapButtons.fire({
            title: '¿Eliminar ' + NOMB + '?',
            text: "Esta acción no se podrá deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                $.post('../controllers/tipoController.php',{ID,funcion},(response)=>{
                    // console.log(response);
                    edit==false;
                    if(response=='borrado'){
                        swalWithBootstrapButtons.fire(
                            'Eliminado ' + NOMB,
                            'El registro ha sido eliminado correctamente',
                            'success'
                        )
                        buscar_tipo();
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error!'+NOMB+'!',
                            'error al eliminar.',
                            'error'
                        )
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
            //   swalWithBootstrapButtons.fire(
            //     'Cancelado',
            //     '',
            //     'error'
            //   )
            }
          })
    })

    $(document).on('click','.editar-tipo',(e)=>{
        const ELEM = $(this)[0].activeElement.parentElement.parentElement;
        const ID = $(ELEM).attr('tipoId');
        const NOMB = $(ELEM).attr('tipoNom');
        $('#id_edit_tipo').val(ID);
        $('#nom_tipo').val(NOMB);
        edit=true;
    })
});