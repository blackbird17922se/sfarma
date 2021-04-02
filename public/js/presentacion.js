$(document).ready(function(){

    buscar_present();

    var funcion;
    var edit = false;   // bandera

    /* Formukario crear editar */
    $('#form-crear-present').submit(e=>{
        let nom_present = $('#nom_present').val();
        let id_editado = $('#id_edit_present').val();

        if(edit==false){
            funcion="crear";
        }else{
            funcion="editar";
        }

        // funcion = 'crear';
        $.post('../controllers/presentacionController.php',{nom_present,id_editado,funcion},(response)=>{
            console.log(response)
            if(response=='add'){
                $('#add-present').hide('slow');
                $('#add-present').show(1000);
                $('#add-present').hide(2000);
                $('#form-crear-present').trigger('reset');
                buscar_present();
            }
            if(response=='noadd'){
                $('#noadd-present').hide('slow');
                $('#noadd-present').show(1000);
                $('#noadd-present').hide(2000);
                $('#form-crear-present').trigger('reset');
            }
            if(response=='edit'){
                $('#edit-present').hide('slow');
                $('#edit-present').show(1000);
                $('#edit-present').hide(2000);
                $('#form-crear-present').trigger('reset');
                buscar_present();
            }
            edit=false;
        });
        e.preventDefault();
    });

    function buscar_present(consulta){
        funcion = 'buscar';
        // ajax
        $.post('../controllers/presentacionController.php',{consulta,funcion},(response)=>{
            // console.log(response);
            const PRESENTS = JSON.parse(response);
            let template = '';
            PRESENTS.forEach(present=>{
                template+=`
                <tr presentId="${present.id_present}" presentNom="${present.nom}">
                    <td>${present.nom}</td>
                    <td>
                        <button class="editar-present btn btn-success" title="editar" type="button" data-toggle="modal" data-target="#crearpresent">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
    
                        <button class="borrar-present btn btn-danger" title="borrar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                `;
            });
            $('#tbd-presents').html(template);
        })
    }
    // evento paara las busquedad
    $(document).on('keyup','#busq-present',function(){
        let valor = $(this).val();
        if(valor != ''){
            buscar_present(valor);
        }else{
            buscar_present();
        }
    });

    $(document).on('click','.borrar-present',(e)=>{
        var funcion = "borrar";
        const ELEM = $(this)[0].activeElement.parentElement.parentElement;
        const ID = $(ELEM).attr('presentId');
        const NOMB = $(ELEM).attr('presentNom');
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
                $.post('../controllers/presentacionController.php',{ID,funcion},(response)=>{
                    // console.log(response);
                    edit==false;
                    if(response=='borrado'){
                        swalWithBootstrapButtons.fire(
                            'Eliminado ' + NOMB,
                            'El registro ha sido eliminado correctamente',
                            'success'
                        )
                        buscar_present();
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

    $(document).on('click','.editar-present',(e)=>{
        const ELEM = $(this)[0].activeElement.parentElement.parentElement;
        const ID = $(ELEM).attr('presentId');
        const NOMB = $(ELEM).attr('presentNom');
        $('#id_edit_present').val(ID);
        $('#nom_present').val(NOMB);
        edit=true;
    })
});