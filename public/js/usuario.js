$(document).ready(function(){

    /* Crear la funcion a ejecutar por parte del controlador */
    var funcion = "";

    /* Capturar el id usuario del formulario hidder usuario */
    /* .val() >>> sirve para obtener el valor de input */
    var id_usu = $('#id_usu').val();

    /* Variable bandera */
    var edit = false;

    /* Invocar funcion y pasarle el parametro id_usu */
    buscarUsuario(id_usu);


    /* Funcion para que a traves del id capturado, ejecute una consulta a la bd */
    function buscarUsuario(id) {
        funcion = "buscarUsuario";
        /* Hacer el Ajax de tipo post. requiere el url, los datos a pasarle y una funcion a ejecuttar */
        $.post('../controllers/usuarioController.php',{id,funcion},(response)=>{
            /* aqui construimos lo que hara la funcion response */

            let nom = '';
            let ape = '';
            let dni_us = '';
            let rol = '';

            /* asignmos a una constante los datos obtenidos pero decodificados del controller */
            const USUARIO = JSON.parse(response);
            /* Asignar a las variables de arriba los vallores que hay dentro de lo que devuelve el json */
            /* USUARIO.nom >> donde "nom" proviene del nombre llave en: 'nom' => $obj... */
            nom+=`${USUARIO.nom}`;
            ape+=`${USUARIO.ape}`;
            dni_us+=`${USUARIO.dni_us}`;
            rol+=`${USUARIO.rol}`;
            // nom+=`${USUARIO.nom}`;

            /* Asignale al campo con id="x" el valor asignado a  las variables let */
            $('#nom').html(nom);
            $('#ape').html(ape);
            $('#dni_us').html(dni_us);
            $('#rol').html(rol);
        })
    }

    /* Asignar evento al boton editar */
    $(document).on('click','.edit',(e)=>{
        /* Cada vez que se haga clik en el boton de clase editar se va a ejecutar: */
        funcion = 'capturarDatos';

        /* Cambiar la bandera a true para permitir la edicion */
        edit = true;

        $.post('../controllers/usuarioController.php',{id_usu,funcion},(response)=>{
            // console.log(response);
            const USUARIOX = JSON.parse(response);

            /* Agregarle a los campos el valor obtenido en el respones */
            // console.log(USUARIOX.nom);
            $('#c_nom').val(USUARIOX.nom);
            $('#c_ape').val(USUARIOX.ape);
        });
    });

    $('#form-usuario').submit(e=>{
        if(edit == true){
            /* Capturar la informacion que se ingreso en los imputs */
            let nom = $('#c_nom').val();
            let ape = $('#c_ape').val();

            funcion = 'editarUsuario';
            $.post('../controllers/usuarioController.php',{id_usu,funcion,nom,ape},(response)=>{
                // console.log(response);
                if(response == 'editado'){
                    $('#editado').hide('slow');
                    $('#editado').show(1000);
                    $('#editado').hide(4000);
                    /* trigger resetea los vlores del formulario (los deja en blanco) */
                    $('#form-usuario').trigger('reset');
                }
                edit = false;
                buscarUsuario(id_usu);        
            });


        }else{
            $('#noeditado').hide('slow');
            $('#noeditado').show(1000);
            $('#noeditado').hide(8000);
            $('#form-usuario').trigger('reset');

        }
        /* Quitar la autorecarga de la pagina al hacer elsubmit */
        e.preventDefault();

    });

    /* FORMULARIO EDICION CONTRASEÑA */
    $('#form-pass').submit(e=>{
        let oldpass = $('#oldpass').val();
        let newpass = $('#newpass').val();

        funcion = 'cambiarContras';
        $.post('../controllers/usuarioController.php',{funcion,oldpass,newpass,id_usu},(response)=>{
            console.log(response);
            if(response == 'update'){
                $('#edit-contras').hide('slow');
                $('#edit-contras').show(1000);
                $('#edit-contras').hide(2000);
                $('#form-pass').trigger('reset');
            }else{
                $('#noedit-contras').hide('slow');
                $('#noedit-contras').show(1000);
                $('#noedit-contras').hide(2000);
                $('#form-pass').trigger('reset');     
            }
        });
        e.preventDefault();
    })
})