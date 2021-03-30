$(document).ready(function(){
    recuperarLS_car();
    // let template = '';

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

        const PRODUCTO = {
            id_prod : ID,
            nombre : NOMB,
            compos : COMPOS,
            adici : ADICI,
            precio : PRECIO,
            laboratorio : PLAB,
            tipo : PTIPO,
            presentacion : PPRES,
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
        }     
    });

    $(document).on('click','.borrar-producto',(e)=>{
        const ELEM = $(this)[0].activeElement.parentElement.parentElement;
        const ID = $(ELEM).attr('prodId');
        ELEM.remove();
        eliminarProdLS(ID);
    })

    /* VACIAR CARRITO */
    $(document).on('click','#vaciar-carrito',(e)=>{
        /* borra todos los elementos del tbody */
        $('#tbd-lista').empty();
        eliminarLS();
    });

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

    function recuperarLS_car(){
        let productos;
        productos = recuperarLS();
        productos.forEach(producto => {
            template=`
            <tr prodId="${producto.id_prod}">
                <td>${producto.id_prod}</td>
                <td>${producto.nombre}</td>
                <td>${producto.compos}</td>
                <td>${producto.adici}</td>
                <td>${producto.precio}</td>
                <td><button class="btn btn-danger borrar-producto" ><i class="fas fa-times-circle"></i></button></td>
            </tr>
            `;
            $('#tbd-lista').append(template);          
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
})