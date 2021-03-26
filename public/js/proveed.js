$(document).ready(function(){
    var funcion;
    var edit = false;   // bandera

    buscar_proveed();
    
    
    /* CREAR*/
    $('#form-crear-proveed').submit(e=>{
        /* recibir los datos del formulario al hacer click en el boton submit */
        /* val(): obtiene el valor en el imput */
        let id_prov = $('#id_edit_proveed').val()
        let nom = $('#nom').val();
        let telef = $('#telef').val();
        let correo = $('#correo').val();
        let direc = $('#direc').val();
 
        // console.log(nom+" "+id_prov);
        if(edit==true){
            funcion="editar";
        }else{
            funcion="crear";
        }

        $.post('../controllers/proveedController.php',{funcion,id_prov,nom,telef,correo,direc},(response)=>{
            // console.log(response);

            if(response=='add'){
                $('#add-proveed').hide('slow');
                $('#add-proveed').show(1000);
                $('#add-proveed').hide(2000);
                $('#form-crear-proveed').trigger('reset');
                buscar_proveed();
            }
            if(response=='edit'){
                $('#edit-proveed').hide('slow');
                $('#edit-proveed').show(1000);
                $('#edit-proveed').hide(2000);
                $('#form-crear-proveed').trigger('reset');
                buscar_proveed();
            }
            if(response=='noadd'){
                $('#noadd-proveed').hide('slow');
                $('#noadd-proveed').show(1000);
                $('#noadd-proveed').hide(2000);
                $('#form-crear-proveed').trigger('reset');
            }
            if(response=='noedit'){
                $('#noadd-proveed').hide('slow');
                $('#noadd-proveed').show(1000);
                $('#noadd-proveed').hide(2000);
                $('#form-crear-proveed').trigger('reset');
            }
            edit = false;
        })
        e.preventDefault();
    });


    /* CONSULTAR */
    function buscar_proveed(consulta){
        funcion = 'buscar';

        $.post('../controllers/proveedController.php',{consulta,funcion},(response)=>{
            // console.log(response);

            const PROVEEDS = JSON.parse(response);
            let template = '';
            PROVEEDS.forEach(proveed=>{
                // <div proveedId="${proveed.id_prov}" proveedx="${proveed.x}" proveedx="${proveed.x}" proveedx="${proveed.x}" proveedx="${proveed.x}" proveedx="${proveed.x}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">

                // console.log(proveed.nom);
                template+=`
                <div proveedId="${proveed.id_prov}" proveednom="${proveed.nom}" proveeddirec="${proveed.direc}" proveedtelef="${proveed.telef}" proveedcorreo="${proveed.correo}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                <i class="fas fa-lg fa-cubes mr-1"></i>${proveed.id_prov}
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-12">
                      <h2 class="lead"><b>${proveed.nom}</b></h2>

                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-cubes"></i></span> ${proveed.telef}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-cubes"></i></span> ${proveed.correo}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-cubes"></i></span> ${proveed.direc}</li>
    
                      </ul>
                    </div>
                   
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <button class="editar btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#crearproveed">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
           
                    <button class="borrar btn btn-sm btn-danger">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
             
                `;
            });

            /* id del card body cb-proveeds */
            $('#cb-proveed').html(template);
        })
    }

    // evento paara las busquedad
    $(document).on('keyup','#buscar-proveed',function(){
        let valor = $(this).val();
        if(valor != ''){
            buscar_proveed(valor);
        }else{
            buscar_proveed();
        }
    });


    $(document).on('click','.editar',(e)=>{
        
        const ELEM = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        // const ID = 'ass';
        const ID = $(ELEM).attr('proveedId');
        const NOMB = $(ELEM).attr('proveednom');
        const TELEF = $(ELEM).attr('proveedtelef');
        const CORREO = $(ELEM).attr('proveedcorreo');
        const DIREC = $(ELEM).attr('proveeddirec');
       
        // console.log(ID + '-' + NOMB + '-' + telef + '-' + direc + '-' + correo + '-' + PLAB + '-' + PTIPO + '-' + PPRES);

        /* LOS ID# SON LOS DE LOS CAMPOSDEL FORM */
        $('#id_edit_proveed').val(ID);
        $('#nom').val(NOMB);
        $('#telef').val(TELEF);
        $('#correo').val(CORREO);
        $('#direc').val(DIREC);

        edit = true;   // bandera
    })


    /* FUN BORRAR */
    $(document).on('click','.borrar',(e)=>{
        var funcion = "borrar";
        const ELEM = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const ID = $(ELEM).attr('proveedId');
        const NOMB = $(ELEM).attr('proveednom');
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
            title: '¿Está seguro que desea eliminar el proveedor '+NOMB+'?',
            text: "Esta acción ya no se podrá deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                $.post('../controllers/proveedController.php',{ID,funcion},(response)=>{
                    // console.log(response);
                    edit==false;
                    if(response=='borrado'){
                        swalWithBootstrapButtons.fire(
                            'Eliminado '+NOMB+'!',
                            'El proveedor ha sido eliminado.',
                            'success'
                        )
                        buscar_proveed();
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error al eliminar '+NOMB,
                            'Error al eliminar el registro.',
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

})