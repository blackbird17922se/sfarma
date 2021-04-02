$(document).ready(function(){

    verificarStock()
    contarProductos();
    recuperarLS_car_compra();
    recuperarLS_car();
    calcularTotal()

    $(document).on('click','.agregar-carrito',(e)=>{
        const ELEM = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const ID = $(ELEM).attr('prodId');
        const NOMB = $(ELEM).attr('prodnombre');
        const COMPOS = $(ELEM).attr('prodcompos');
        const PRECIO = $(ELEM).attr('prodprecio');
        const ADICI = $(ELEM).attr('prodadici');
        const PLAB = $(ELEM).attr('prodlab');
        const PTIPO = $(ELEM).attr('prodtipo');
        const PPRES = $(ELEM).attr('prodpres');
        const STOCK = $(ELEM).attr('prodStock');

        const PRODUCTO = {
            id_prod : ID,
            nombre : NOMB,
            compos : COMPOS,
            adici : ADICI,
            precio : PRECIO,
            laboratorio : PLAB,
            tipo : PTIPO,
            presentacion : PPRES,
            stock : STOCK,
            cantidad : 1
        }

        /* verificar si el producto existe ya en el carr */
        let id_prod;
        let products;
        products = recuperarLS();
        products.forEach(prod=>{
            if(prod.id_prod === PRODUCTO.id_prod){
                id_prod = prod.id_prod
            }
        })

        if(id_prod === PRODUCTO.id_prod){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ya ingresaste este producto al carrito',
            })
        }else{
            template=`
            <tr prodId="${PRODUCTO.id_prod}">
                <td>${PRODUCTO.id_prod}</td>
                <td>${PRODUCTO.nombre}</td>
                <td>${PRODUCTO.compos}</td>
                <td>${PRODUCTO.adici}</td>
                <td>${PRODUCTO.precio}</td>
                <td><button class="btn btn-danger borrar-producto" ><i class="fas fa-times-circle"></i></button></td>
            </tr>
            `;
            $('#tbd-lista').append(template);
            agregarLS(PRODUCTO);
            contarProductos();
        }     
    });

    $(document).on('click','.borrar-producto',(e)=>{
        const ELEM = $(this)[0].activeElement.parentElement.parentElement;
        const ID = $(ELEM).attr('prodId');
        ELEM.remove();
        eliminarProdLS(ID);
        contarProductos();
        calcularTotal()
    })

    /* VACIAR CARRITO */
    $(document).on('click','#vaciar-carrito',(e)=>{
        /* borra todos los elementos del tbody */
        $('#tbd-lista').empty();
        eliminarLS();
        contarProductos();
        calcularTotal()
    });

    /* la e es de evento */
    $(document).on('click','#procesar-pedido',(e)=>{
        procesarPedido();
    })

    $(document).on('click','#procesar-compra',(e)=>{
        procesarCompra();
    })

    function recuperarLS(){
        let productos;
        if(localStorage.getItem('productos')===null){
            productos=[];
        }else{
            productos = JSON.parse(localStorage.getItem('productos'));
        }
        return productos;
    }

    function agregarLS(producto){
        let productos;
        productos = recuperarLS();
        productos.push(producto);
        localStorage.setItem('productos',JSON.stringify(productos));
    }

    /* Recupera los datos del LS en el carrito */
    function recuperarLS_car(){
        let productos, id_producto;
        productos = recuperarLS();
        funcion="buscar_id";
        productos.forEach(producto => {
            id_producto =producto.id_prod;
            $.post('../controllers/productoController.php',{funcion,id_producto},(response)=>{
                // console.log(response);
                let template_car='';
                /* decodificar el json response */
                let json = JSON.parse(response);
                template_car=`
                    <tr prodId="${json.id_prod}">
                        <td>${json.id_prod}</td>
                        <td>${json.nombre}</td>
                        <td>${json.compos}</td>
                        <td>${json.adici}</td>
                        <td>${json.precio}</td>
                        <td><button class="btn btn-danger borrar-producto" ><i class="fas fa-times-circle"></i></button></td>
                    </tr>
                `;
                /* no se hace forech porque se esta recibiendo objeto por objeto */
                $('#tbd-lista').append(template_car);          
            });        
        });
    }

    function eliminarProdLS(ID){
        let productos;
        productos = recuperarLS();
        productos.forEach(function(producto,indice){
            if(producto.id_prod === ID){
                productos.splice(indice,1);
            }
        });
        localStorage.setItem('productos',JSON.stringify(productos));
    }

    function eliminarLS(){
        localStorage.clear();
    }

    function contarProductos(){
        let productos;
        let contador = 0;
        productos = recuperarLS();
        productos.forEach(producto=>{
            contador++;
        });
        // return contador;
        $('#contador').html(contador);
    }

    function procesarPedido(){
        let productos;
        productos = recuperarLS();
        if(productos.length === 0){
            Swal.fire({
                icon: 'error',
                title: 'Atencion',
                text: 'El Carrito esta vacio',
            })
        }else{
            location.href = '../views/adm_compra.php';
        }
    }


    /*
     *Funcion para imprimir en la tabla de la vista adm_compra
     *los items que se han almacenado en el local storage
    */
    async function recuperarLS_car_compra(){

        let productos;
        funcion="traer_productos";
        productos = recuperarLS();

        const RESPONSE = await fetch('../controllers/productoController.php',{
            method:'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'funcion='+funcion+'&&productos='+JSON.stringify(productos)
        });
        let resultado = await RESPONSE.text();
        // console.log(resultado);
        $('#lista-compra').append(resultado);          
    }


    /* Evento boton actualizar */
    $(document).on('click','#actualizar',(e)=>{
        let productos, precios;
        precios = document.querySelectorAll('.precio');
        productos = recuperarLS();
        productos.forEach(function(producto,indice){
            producto.precio = precios[indice].textContent;
        });
        localStorage.setItem('productos',JSON.stringify(productos));
        calcularTotal();
    })

    /* evento para que cuando en el campo de cantidad en adm_compra se le modifique la cantidad
    capture ese dato y lo modifique en el local storage */
    $('#cp').keyup((e)=>{
        let id, cantidad, producto, productos, montos, precio;
        /* la var producto capturara toda la fila <tr> en la tabla de compra */
        producto = $(this)[0].activeElement.parentElement.parentElement;
        /* compaarar id y modificar la  coantidad */
        id =$(producto).attr('prodId');
        precio =$(producto).attr('prodPrecio');
        /* Capturar el valor del input de cantidad, pero ya que cada producto genera una fila
        la cual tiene su input cantidad, se realiza lo siguiente: con queryselector
        seleccionara todos los 'input' que vaya generando cada producto */
        cantidad = producto.querySelector('input').value;

        /* Capturar todos los subtotales de la tabla, captura todos los td de clase 'subtotales' */
        montos = document.querySelectorAll('.subtotales');

        /* Recuperar todos los datos del LocalStorage */
        productos = recuperarLS();
        /* foreach para recuperar lo almacenado */
        productos.forEach(function(prod, indice){
            // console.log("hola" + prod.id_prod);
            /* seleccionar y comparar los ida. busca en todos los id el que sea igual al id en el cual se esta editando la cantidad */
            if(prod.id_prod === id){
                /* al indice cantidad (hubicado en el LS) se le asigna el valor ingresado en el input cantidad */
                prod.cantidad = cantidad;
                prod.precio = precio;
                /* capturar el subtotal del producto en cuestion 
                */
                montos[indice].innerHTML = `<h5>${cantidad*precio}</h5>`;
            }
        });
        localStorage.setItem('productos',JSON.stringify(productos));
        calcularTotal()
    })

    function calcularTotal(){

        let productos,
            subtotal,
            totSinDescuento,
            conIgv,
            total = 0,
            igv = 0.18,
            pago,
            vuelto,
            descuento;

        productos = recuperarLS();
        /* este buble recorre los productos en el carrito */
        productos.forEach(producto => {
            let subtotProd = Number(producto.precio*producto.cantidad);
            total+=subtotProd;
        });

        /* Capturar valor imputs */
        pago = $('#pago').val();
        descuento = $('#descuento').val();

        total-=descuento;
        vuelto=pago-total;
        // console.log(total);
        totSinDescuento= total.toFixed(2)
        conIgv = parseFloat(total * igv).toFixed(2);
        subtotal = parseFloat(total-conIgv).toFixed(2);

        $('#subtotal').html(subtotal);
        $('#con_igv').html(conIgv);
        $('#total_sin_descuento').html(totSinDescuento);
        $('#total').html(total.toFixed(2));
        $('#vuelto').html(vuelto.toFixed(2));
    }

    function procesarCompra(){
        let nombre = $('#cliente').val();
        if(recuperarLS().length == 0){
            Swal.fire({
                icon: 'error',
                title: 'Atencion',
                text: 'El Carrito esta vacio',
            }).then(function(){
                location.href = '../views/adm_cat.php'
            })
        }else{
            verificarStock().then(error=>{
                // console.log(error);
                if(error==0){
                    registrarCompra(nombre);
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Compra Exitosa',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function(){
                        eliminarLS();
                        location.href = '../views/adm_cat.php'
                    });

                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Atencion',
                        text: 'No hay  stock en algun producto',
                    })
                }
            });
            
        }
    }

    /* Verificar si hay stock */
    async function verificarStock(){
        let productos;
        funcion = 'verificar-stock';
        productos = recuperarLS();

        const RESPONSE = await fetch('../controllers/productoController.php',{
            method:'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'funcion='+funcion+'&&productos='+JSON.stringify(productos)
        });
        let error = await RESPONSE.text();
        return error;
    }

    function registrarCompra(nombre){
        funcion = 'registrarCompra';
        /* capturar el dato en el campo total . get[0]= obtener el primer dato*/
        let total = $('#total').get(0).textContent;
        let productos = recuperarLS();
        // let nomb = "mxpr";
        /* nviar ese producto al controlador */
        let json = JSON.stringify(productos);
        $.post('../controllers/compraController.php',{funcion,total,json,nombre},(response)=>{
            console.log(response);
        })

    }

})
