$(document).ready(function(){
    var funcion;
    var edit = false;   // bandera

    /* buscara los campos de lista desplegable con la clase select2 + la funcion interna select2*/
    $('.select2').select2();
    buscar_producto();
    
    /* Funciones para llenar las listad desplegables */
    listar_labs();
    function listar_labs(){
        funcion = "listar_labs";
        $.post('../controllers/laboratorioController.php',{funcion},(response)=>{
            // console.log(response);
            const LABS = JSON.parse(response);
            let template = '';
            LABS.forEach(lab=>{
                template+=`
                    <option value="${lab.id_lab}">${lab.nom_lab}</option>
                `;
            });
            /* id del campo que contiene el listado */
            $('#prod_lab').html(template);
        })
    }

    listar_tipos();
    function listar_tipos(){
        funcion = "listar_tipos";
        $.post('../controllers/tipoController.php',{funcion},(response)=>{
            // console.log(response);
            const TIPOS = JSON.parse(response);
            let template = '';
            TIPOS.forEach(tipo=>{
                template+=`
                    <option value="${tipo.id_tipo}">${tipo.nom_tipo}</option>
                `;
            });
            /* id del campo que contiene el listado */
            $('#prod_tipo').html(template);
        })
    }

    listar_presents();
    function listar_presents(){
        funcion = "listar_presents";
        $.post('../controllers/presentacionController.php',{funcion},(response)=>{
            // console.log(response);
            const PRESENTS = JSON.parse(response);
            let template = '';
            PRESENTS.forEach(present=>{
                template+=`
                    <option value="${present.id_present}">${present.nom_present}</option>
                `;
            });
            /* id del campo que contiene el listado */
            $('#prod_present').html(template);
        })
    }
    $('#form-crear-product').submit(e=>{
        /* recibir los datos del formulario al hacer click en el boton submit */
        /* val(): obtiene el valor en el imput */
        let nombre = $('#nombre').val();
        let compos = $('#compos').val();
        let adici = $('#adici').val();
        let precio = $('#precio').val();
        let prod_lab = $('#prod_lab').val();
        let prod_tipo = $('#prod_tipo').val();
        let prod_present = $('#prod_present').val();
        console.log(nombre+" "+compos+" "+adici+" "+precio+" "+prod_lab+" "+prod_tipo+" "+prod_present);
        funcion = "crear";
        $.post('../controllers/productoController.php',{funcion,nombre,compos,adici,precio,prod_lab,prod_tipo,prod_present},(response)=>{
            console.log(response);

            if(response=='add'){
                $('#add-product').hide('slow');
                $('#add-product').show(1000);
                $('#add-product').hide(2000);
                $('#form-crear-product').trigger('reset');
                buscar_producto();
            }
            if(response=='noadd'){
                $('#noadd-product').hide('slow');
                $('#noadd-product').show(1000);
                $('#noadd-product').hide(2000);
                $('#form-crear-product').trigger('reset');
            }
            if(response=='edit'){
                $('#edit-product').hide('slow');
                $('#edit-product').show(1000);
                $('#edit-product').hide(2000);
                $('#form-crear-product').trigger('reset');
                buscar_producto();
            }

        })
        e.preventDefault();
    });

    function buscar_producto(consulta){
        funcion = 'buscar';
        // ajax
        $.post('../controllers/productoController.php',{consulta,funcion},(response)=>{
            // console.log(response);

            const PRODUCTS = JSON.parse(response);
            let template = '';
            PRODUCTS.forEach(product=>{
                // <div productId="${product.id_prod}" productx="${product.x}" productx="${product.x}" productx="${product.x}" productx="${product.x}" productx="${product.x}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">

                template+=`
                <div prodId="${product.id_prod}" prodnombre="${product.nombre}" prodprecio="${product.precio}" prodcompos="${product.compos}" prodadici="${product.adici}" prodlab="${product.lab_id}" prodtipo="${product.tipo_id}" prodpres="${product.pres_id}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                <i class="fas fa-lg fa-cubes mr-1"></i>${product.stock}
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-12">
                      <h2 class="lead"><b>${product.nombre}</b></h2>
                      <h4 class="lead"><b><i class="fas fa-lg fa-dollar-sign mr-1"></i>${product.precio}</b></h4>

                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-cubes"></i></span> ${product.compos}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-cubes"></i></span> ${product.adici}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-cubes"></i></span> ${product.laboratorio}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-cubes"></i></span> ${product.tipo}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-cubes"></i></span> ${product.presentacion}</li>
                      </ul>
                    </div>
                   
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <button class="editar btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#crearproduct">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button class="lote btn btn-sm btn-primary">
                        <i class="fas fa-plus-square"></i>
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

            /* id del card body cb-products */
            $('#cb-products').html(template);
        })
    }

    // evento paara las busquedad
    $(document).on('keyup','#busq-product',function(){
        let valor = $(this).val();
        if(valor != ''){
            buscar_producto(valor);
        }else{
            buscar_producto();
        }
    });


    $(document).on('click','.editar',(e)=>{
        
        const ELEM = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        // const ID = 'ass';
        const ID = $(ELEM).attr('prodId');
        const NOMB = $(ELEM).attr('prodnombre');
        const COMPOS = $(ELEM).attr('prodcompos');
        const PRECIO = $(ELEM).attr('prodprecio');
        const ADICI = $(ELEM).attr('prodadici');
        const PLAB = $(ELEM).attr('prodlab');
        const PTIPO = $(ELEM).attr('prodtipo');
        const PPRES = $(ELEM).attr('prodpres');
        // console.log(ID + '-' + NOMB + '-' + COMPOS + '-' + PRECIO + '-' + ADICI + '-' + PLAB + '-' + PTIPO + '-' + PPRES);

        /* LOS ID# SON LOS DE LOS CAMPOSDEL FORM */
        $('#id_edit-prod').val(ID);
        $('#nombre').val(NOMB);
        $('#compos').val(COMPOS);
        $('#adici').val(ADICI);
        $('#precio').val(PRECIO);
        $('#prod_lab').val(PLAB).trigger('change');
        $('#prod_tipo').val(PTIPO).trigger('change');
        $('#prod_present').val(PPRES).trigger('change');
        edit = true;   // bandera


 
    })

})