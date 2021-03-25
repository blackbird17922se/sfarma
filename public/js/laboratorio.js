$(document).ready(function(){
    busq_lab();

    var funcion;
    var edit = false;   // bandera

    $('#form-crear-lab').submit(e=>{
        let nom_lab = $('#nom_lab').val();
        let id_editado = $('#id_edit-lab').val();

        if(edit==false){
            funcion="crear";
        }else{
            funcion="editar";
        }

        // funcion = 'crear';
        $.post('../controllers/laboratorioController.php',{nom_lab,id_editado,funcion},(response)=>{
            // console.log(response)
            if(response=='add'){
                $('#add-lab').hide('slow');
                $('#add-lab').show(1000);
                $('#add-lab').hide(2000);
                $('#form-crear-lab').trigger('reset');
                busq_lab();
            }
            if(response=='noadd'){
                $('#noadd-lab').hide('slow');
                $('#noadd-lab').show(1000);
                $('#noadd-lab').hide(2000);
                $('#form-crear-lab').trigger('reset');
            }
            if(response=='edit'){
                $('#edit-lab').hide('slow');
                $('#edit-lab').show(1000);
                $('#edit-lab').hide(2000);
                $('#form-crear-lab').trigger('reset');
                busq_lab();
            }
            edit==false;
        });
        e.preventDefault();
    });

    function busq_lab(consulta){
        funcion = 'buscar';
        // ajax
        $.post('../controllers/laboratorioController.php',{consulta,funcion},(response)=>{
            // console.log(response);
            const LABS = JSON.parse(response);
            let template = '';
            LABS.forEach(lab=>{
                template+=`
                <tr labId="${lab.id_lab}" labNom="${lab.nom_lab}">
                    <td>${lab.nom_lab}</td>
                    <td>
                        <button class="editar btn btn-success" title="editar" type="button" data-toggle="modal" data-target="#crearlab">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
    
                        <button class="borrar btn btn-danger" title="borrar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                `;
            });
            $('#tbd-labs').html(template);
        })
    }
    // evento paara las busquedad
    $(document).on('keyup','#busq-lab',function(){
        let valor = $(this).val();
        if(valor != ''){
            busq_lab(valor);
        }else{
            busq_lab();
        }
    });

    $(document).on('click','.borrar',(e)=>{
        var funcion = "borrar";
        const ELEM = $(this)[0].activeElement.parentElement.parentElement;
        const ID = $(ELEM).attr('labId');
        const NOMB = $(ELEM).attr('labNom');
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
            title: 'Are you sure eliminar '+NOMB+'?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                $.post('../controllers/laboratorioController.php',{ID,funcion},(response)=>{
                    // console.log(response);
                    edit==false;
                    if(response=='borrado'){
                        swalWithBootstrapButtons.fire(
                            'Deleted!'+NOMB+'!',
                            'Your file has been deleted.',
                            'success'
                        )
                        busq_lab();
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error!'+NOMB+'!',
                            'error al eliminar.',
                            'error'
                        )
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              swalWithBootstrapButtons.fire(
                'Cancelado',
                '',
                'error'
              )
            }
          })
    })

    $(document).on('click','.editar',(e)=>{
        const ELEM = $(this)[0].activeElement.parentElement.parentElement;
        const ID = $(ELEM).attr('labId');
        const NOMB = $(ELEM).attr('labNom');
        $('#id_edit-lab').val(ID);
        $('#nom_lab').val(NOMB);
        edit=true;
    })
});