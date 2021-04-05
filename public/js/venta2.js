$(document).ready(function () {
    let funcion = "listar";
    // $.post("../controllers/ventaController.php", {funcion},(response)=>{
    //     console.log(JSON.parse(response));
    // });

    
    /* CONSULTAR USUARIO PARA OCULTA O O EL BORTON ELIMINAR (EXPERIMENTO ADANDONADO)  */
    // function consultarRol() {
    //     funcion = "consultarRol";
    //     /* Hacer el Ajax de tipo post. requiere el url, los datos a pasarle y una funcion a ejecuttar */
    //     $.post('../controllers/usuarioController.php',{funcion},(response)=>{
    //         console.log(response);
    //     })
    // }

    let datatable = $('#tabla_venta').DataTable( {
        
        "ajax": {
            "url":"../controllers/ventaController.php",
            "method":"POST",
            "data":{funcion:funcion}
        },
        "columns": [

            { "data": "id_venta" },
            { "data": "fecha" },
            { "data": "cliente" },
            { "data": "total" },
            { "data": "vendedor" },
            { "defaultContent": `
                <button class="imprimir btn btn-secondary"><i class="fas fa-print"></i></button>
                <button class="ver btn btn-success" type="button" data-toggle="modal" data-target="#vista-venta"><i class="fas fa-search"></i></button>
            `},
        ],
        language: espanol
    } );

    /* CODIGO DE GENERAR PDF */
    $('#tabla_venta tbody').on('click','.imprimir',function(){
        let datos = datatable.row($(this).parents()).data();
        let id= datos.id_venta;
        $.post('../controllers/PDFController.php',{id},(response)=>{
            console.log(response);
            window.open('../pdf/pdf-'+id+'.pdf','_blank');
        });
    });



    /* seleccionar elid de esa fila para consultar sus valores */
    $('#tabla_venta tbody').on('click','.ver',function(){

        let datos = datatable.row($(this).parents()).data();
        let id= datos.id_venta;
        // let id= datos.id_venta;
        funcion = 'ver';
        // console.log(id);

        $('#codigo_venta').html(datos.id_venta);
        $('#fecha').html(datos.fecha);
        $('#cliente').html(datos.cliente);
        $('#vendedor').html(datos.vendedor);
        $('#total').html(datos.total);
        $.post('../controllers/ventaProductoController.php',{funcion,id},(response)=>{
            let registros = JSON.parse(response);
            let template ="";
            $('#registros').html(template);

            registros.forEach(registro => {
                template+=`
                <tr>
                    <td>${registro.cant}</td>
                    <td>${registro.precio}</td>
                    <td>${registro.producto}</td>
                    <td>${registro.compos}</td>
                    <td>${registro.adici}</td>
                    <td>${registro.laboratorio}</td>
                    <td>${registro.presentacion}</td>
                    <td>${registro.tipo}</td>
                    <td>${registro.subtotal}</td>
                </tr>
                `;
                $('#registros').html(template);
                
            });
            console.log(response);   
        })
    });
});



/* DATATABLE A ESPAÑOL */
let espanol = {
    "aria": {
        "sortAscending": "Activar para ordenar la columna de manera ascendente",
        "sortDescending": "Activar para ordenar la columna de manera descendente"
    },
    "autoFill": {
        "cancel": "Cancelar",
        "fill": "Rellene todas las celdas con <i>%d&lt;\\\/i&gt;<\/i>",
        "fillHorizontal": "Rellenar celdas horizontalmente",
        "fillVertical": "Rellenar celdas verticalmentemente"
    },
    "buttons": {
        "collection": "Colección",
        "colvis": "Visibilidad",
        "colvisRestore": "Restaurar visibilidad",
        "copy": "Copiar",
        "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
        "copySuccess": {
            "1": "Copiada 1 fila al portapapeles",
            "_": "Copiadas %d fila al portapapeles"
        },
        "copyTitle": "Copiar al portapapeles",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
            "-1": "Mostrar todas las filas",
            "1": "Mostrar 1 fila",
            "_": "Mostrar %d filas"
        },
        "pdf": "PDF",
        "print": "Imprimir"
    },
    "decimal": ",",
    "emptyTable": "No se encontraron resultados",
    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    "infoThousands": ",",
    "lengthMenu": "Mostrar _MENU_ registros",
    "loadingRecords": "Cargando...",
    "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    "processing": "Procesando...",
    "search": "Buscar:",
    "searchBuilder": {
        "add": "Añadir condición",
        "button": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
        },
        "clearAll": "Borrar todo",
        "condition": "Condición",
        "data": "Data",
        "deleteTitle": "Eliminar regla de filtrado",
        "leftTitle": "Criterios anulados",
        "logicAnd": "Y",
        "logicOr": "O",
        "rightTitle": "Criterios de sangría",
        "title": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
        },
        "value": "Valor"
    },
    "searchPanes": {
        "clearMessage": "Borrar todo",
        "collapse": {
            "0": "Paneles de búsqueda",
            "_": "Paneles de búsqueda (%d)"
        },
        "count": "{total}",
        "countFiltered": "{shown} ({total}",
        "emptyPanes": "Sin paneles de búsqueda",
        "loadMessage": "Cargando paneles de búsqueda",
        "title": "Filtros Activos - %d"
    },
    "select": {
        "1": "%d fila seleccionada",
        "_": "%d filas seleccionadas",
        "cells": {
            "1": "1 celda seleccionada",
            "_": "$d celdas seleccionadas"
        },
        "columns": {
            "1": "1 columna seleccionada",
            "_": "%d columnas seleccionadas"
        }
    },
    "thousands": ",",
    "zeroRecords": "No se encontraron resultados",
    "datetime": {
        "previous": "Anterior",
        "next": "Proximo",
        "hours": "Horas",
        "minutes": "Minutos",
        "seconds": "Segundos",
        "unknown": "-",
        "amPm": [
            "am",
            "pm"
        ]
    },
    "editor": {
        "close": "Cerrar",
        "create": {
            "button": "Nuevo",
            "title": "Crear Nuevo Registro",
            "submit": "Crear"
        },
        "edit": {
            "button": "Editar",
            "title": "Editar Registro",
            "submit": "Actualizar"
        },
        "remove": {
            "button": "Eliminar",
            "title": "Eliminar Registro",
            "submit": "Eliminar",
            "confirm": {
                "_": "¿Está seguro que desea eliminar %d filas?",
                "1": "¿Está seguro que desea eliminar 1 fila?"
            }
        },
        "error": {
            "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\\\\\/a&gt;).&lt;\\\/a&gt;<\/a>"
        },
        "multi": {
            "title": "Múltiples Valores",
            "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
            "restore": "Deshacer Cambios",
            "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
        }
    }
} 