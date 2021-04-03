$(document).ready(function(){
    var funcion;
    var edit = false;   // bandera

    buscar_lote();

    function buscar_lote(consulta){
        funcion = 'buscar';
        // ajax
        $.post('../controllers/loteController.php',{consulta,funcion},(response)=>{
            // console.log(response);

            const LOTES = JSON.parse(response);
            let template = '';
            LOTES.forEach(lote=>{
                template+=`
                <div loteId="${lote.id_lote}" loteStock="${lote.stock}" class="col-12 col-sm-6 col-md-3 align-items-stretch">`;
                if(lote.estado=='light'){
                    template+=`<div class="card bg-light">`;
                }
                if(lote.estado=='warning'){
                    template+=`<div class="card bg-warning">`;
                }
                if(lote.estado=='danger'){
                    template+=`<div class="card bg-danger">`;
                }
                
                template+=`<div class="card-header border-bottom-0">
                <i class="fas fa-lg fa-cubes mr-1"></i>${lote.stock}
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-12">
                      <h2 class="lead"><b>${lote.nombre}</b></h2>
                      <h2 >Codigo lote: <b>${lote.id_lote}</b></h2>

                      <ul class="ml-4 mb-0 fa-ul">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-mortar-pestle"></i></span>Concentración: ${lote.compos}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-flask"></i></span>Laboratorio: ${lote.laboratorio}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-copyright"></i></span>Tipo: ${lote.tipo}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-pills"></i></span>Presentación: ${lote.presentacion}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-prescription-bottle-alt"></i></span>Info.Adicional: ${lote.adici}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-truck"></i></span>Proveedor: ${lote.prov_nom}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-times"></i></span>Vencimiento: ${lote.vencim}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-alt"></i></span>Meses para vencer: ${lote.mes}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-day"></i></span>Dias para vencer: ${lote.dia}</li>
                        
                      </ul>
                    </div>
                   
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <button class="editar btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#editarlote">
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
            $('#cb-lotes').html(template);
        })
    }

    /* BUSCAR */
    $(document).on('keyup','#buscar-lote',function(){
        let valor = $(this).val();
        if(valor != ''){
            buscar_lote(valor);
        }else{
            buscar_lote();
        }
    });


    $(document).on('click','.editar',(e)=>{
        
        const ELEM = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const ID = $(ELEM).attr('loteId');
        const STOCK = $(ELEM).attr('loteStock');

        /* LOS ID# SON LOS DE LOS CAMPOSDEL FORM */
        $('#lote_id_prod').val(ID);
        $('#stock').val(STOCK);
        $('#id_lote').html(ID);
        edit = true;   // bandera
    })


    $(document).on('click','.lote',(e)=>{
        const ELEM = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const ID = $(ELEM).attr('prodId');
        const NOMB = $(ELEM).attr('prodnombre');

        $('#lote_id_prod').val(ID);
        $('#nom_lote_lote').html(NOMB);
        // console.log(ID + '-' + NOMB);
        edit = true;   // bandera
    })


    /* FUN BORRAR */
    $(document).on('click','.borrar',(e)=>{
        var funcion = "borrar";
        const ELEM = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const ID = $(ELEM).attr('loteId');
        // const NOMB = $(ELEM).attr('loteStock');
        console.log(ID);

        // Alerta

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-1'
            },
            buttonsStyling: false
          })
          
          swalWithBootstrapButtons.fire({
            title: '¿Está seguro que desea eliminar el lote '+ID+'?',
            text: "Esta acción ya no se podrá deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                $.post('../controllers/loteController.php',{ID,funcion},(response)=>{
                    // console.log(response);
                    edit==false;
                    if(response=='borrado'){
                        swalWithBootstrapButtons.fire(
                            'Eliminado '+ID+'!',
                            'El lote ha sido eliminado.',
                            'success'
                        )
                        buscar_lote();
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error al eliminar '+ID,
                            'El lote está siendo usado en un lote.',
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
    });

    $('#form-editar-lote').submit(e=>{

        let lote_id_prod = $('#lote_id_prod').val()
        let stock = $('#stock').val();

        funcion="editar";

        // funcion = "crear";
        $.post('../controllers/loteController.php',{funcion,lote_id_prod,stock},(response)=>{
            // console.log("mau " + response);
            console.log(response);


            if(response=='edit'){
                $('#edit-lote').hide('slow');
                $('#edit-lote').show(1000);
                $('#edit-lote').hide(2000);
                $('#form-crear-lote').trigger('reset');
                buscar_lote();
            }
            
            edit = false;
        })
        e.preventDefault();
    });

})