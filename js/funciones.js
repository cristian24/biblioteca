$(document).ready(function($) {

//var base_url = 'http://localhost/biblioteca/index.php/'
var base_url = $('body').attr('uri')+'index.php/';

/**
 * ----------------------------------------------------------------------------------------
 * ----------------------------------------------------------------------------------------
 * ------------------------------------Peticiones------------------------------------------
 * ----------------------------------------------------------------------------------------
 * ----------------------------------------------------------------------------------------
 */

function llenar_lista_editoriales()
{
    $.ajax({
        url: base_url+'editoriales/list_editoriales',
        type: 'GET',       
        success: function(data){
            $('#selct_editorial').html('');
            var json = JSON.parse(data);
            if(json.res === 'success')
            {
                $.each(json.list_editoriales, function(index, valor)
                {
                    $('#selct_editorial').append('<option value="'+valor.id+'">'+valor.nombre+'</option>')
                });
            }else
            {
                alert('error actualizando editoriales, porfavor recargue la pagina actual');
            }                        
        },
        error: function(xhr){
            console.log("error: "+xhr);
        }
    });
}

function llenar_lista_autores()
{
    $.ajax({
        url: base_url+'autores/list_autores',
        type: 'GET',       
        success: function(data){
            $('#selct_autor').html('');
            var json = JSON.parse(data);
            if(json.res === 'success')
            {
                $.each(json.list_autores, function(index, valor)
                {
                    $('#selct_autor').append('<option value="'+valor.id+'">'+valor.nombre+'</option>')
                });
            }else
            {
                alert('error actualizando autores, porfavor recargue la pagina actual');
            }                        
        },
        error: function(xhr){
            console.log("error: "+xhr);
        }
    });
}

function get_autores(query)
{
    if(query.length > 0)
    {
        $.ajax({
            url: base_url+'autores/query_rqst/'+query,
            type: 'GET',
            success: success_query_autors,
            error: function(){}
        });
    }else
    {
        $.ajax({
            url: base_url+'autores/query_rqst/TODO',
            type: 'GET',
            success: success_query_autors,
            error: function(){}
        });
    }
}

function get_editoriales(query)
{
    if(query.length > 0)
    {
        $.ajax({
            url: base_url+'editoriales/query_rqst/'+query,
            type: 'GET',
            success: success_query_editoriales,
            error: function(){}
        });
    }else
    {
        $.ajax({
            url: base_url+'editoriales/query_rqst/TODO',
            type: 'GET',
            success: success_query_editoriales,
            error: function(){}
        });
    }
}

$('#form_login').on('submit', function(e)
{
	$.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        success: function(data)
        {
            var json = JSON.parse(data); 
            //console.log(json);                         
            $('#error_login,#error_pass').html('').css('display', 'none');
            $('#user_invalid').html('').css('display', 'none');
            
            if(json.res === 'error')
            {
                if(json.login)
                {
                    $('#error_login').append(json.login).css('display','block');
                }
                if(json.pass)
                {
                    $('#error_pass').append(json.pass).css('display','block');
                }
            }else
            {   console.log(json.datos);
                if(json.datos === 'invalid')
                {
                    $('#user_invalid').append('Login/Pass Incorrectos').css('display','block');
                }else
                {                    
                    mostrar_mensaje(
                                    'Mensaje BiblioCristian',
                                    'Bienvenido Usuario <strong class="text-primary">'+json.datos.login+'</strong>'
                                    );
                    setTimeout(function()
                    {
                        ocultar_mensaje();
                        window.location.href = base_url;
                    }, 2000);                    
                    //$('body').load(base_url+'home/index');                    
                    /*$.post(base_url+'home/index_ajax', '', function(data)
                    {
                        $('#contenido').html(data);
                    });*/
                }
            }
        },
        error: function(xhr, exception)
        {
            console.log(xhr);
        }
    });

	e.preventDefault();
});

$('#camp_query_user').on('keyup', function(e){
    var query = $(this).val();
    $.ajax({
        url: base_url+'usuarios/query_rqst/'+query,
        type: 'GET',
        success: success_query_user,
        error: function(){}
    });    
});

$('#create_autor_modal').on('submit', '#form_create_autor', function(e)
{
    $('#btn_create_autor').attr("disabled", true);
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),        
        success: function(data){
            $('#err_name_autor').html('').css('display', 'none');
            $('#ok_name_autor').html('').css('display', 'none');

            var json = JSON.parse(data);
            if(json.res === 'error')
            {
                $('#err_name_autor').html(json.name).css('display', 'block');
                $('#btn_create_autor').attr("disabled", false);
            }else
            {
                if(json.rqst)
                {
                    $('#ok_name_autor').html('El Autor '+json.name+' se creo satisfactoriamente').css('display', 'block');
                    llenar_lista_autores();
                    setTimeout(function()
                    {
                        $('#create_autor_modal').modal('hide')
                    }, 2000);
                }else
                {
                    $('#err_name_autor').html('Error en la Base de Datos').css('display', 'block');
                }
            }
        },
        error: function(xhr)
        {
            $('#err_name_autor').html('Error de Servidor '+ xhr).css('display', 'block');
        }
    });
    e.preventDefault();
});

$('#create_editorial_modal').on('submit', '#form_create_editorial', function(e)
{
    $('#btn_create_editorial').attr("disabled", true);
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),        
        success: function(data){
            $('#err_name_editorial').html('').css('display', 'none');
            $('#ok_name_editorial').html('').css('display', 'none');

            var json = JSON.parse(data);
            if(json.res === 'error')
            {
                $('#err_name_editorial').html(json.name).css('display', 'block');
                $('#btn_create_editorial').attr("disabled", false);
            }else
            {
                if(json.rqst)
                {
                    $('#ok_name_editorial').html('La Editorial '+json.name+' se creo satisfactoriamente').css('display', 'block');                    
                    llenar_lista_editoriales();
                    setTimeout(function()
                    {
                        $('#create_editorial_modal').modal('hide')
                    }, 2000);
                }else
                {
                    $('#err_name_editorial').html('Error en la Base de Datos').css('display', 'block');
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            $('#err_name_editorial').html('Error de Servidor '+ textStatus).css('display', 'block');
        }
    });
    e.preventDefault();
});

$('#edit_autor_modal').on('submit', '#form_edit_autor', function(e)
{
    $('#btn_edit_autor').attr("disabled", true);
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),        
        success: function(data){
            $('#err_name_autor').html('').css('display', 'none');
            $('#ok_name_autor').html('').css('display', 'none');
            var json = JSON.parse(data);
            if(json.res === 'error')
            {
                $('#err_name_autor').html(json.name).css('display', 'block');
                $('#btn_edit_autor').attr("disabled", false);
            }else
            {
                console.log(json.rqst);
                if(json.rqst)
                {
                    $('#ok_name_autor').html('El Autor se Modifio satisfactoriamente').css('display', 'block');
                    llenar_tabla_autores();
                    setTimeout(function()
                    {
                        $('#edit_autor_modal').modal('hide')
                    }, 2000);
                }else
                {
                    $('#err_name_autor').html('Error en la Base de Datos').css('display', 'block');
                }
            }
        },
        error: function(xhr)
        {
            $('#err_name_autor').html('Error de Servidor '+ xhr).css('display', 'block');
        }
    });
    e.preventDefault();
});

$('#edit_editorial_modal').on('submit', '#form_edit_editorial', function(e)
{
    $('#btn_update_editorial').attr("disabled", true);
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),        
        success: function(data){
            $('#err_name_editorial').html('').css('display', 'none');
            $('#ok_name_editorial').html('').css('display', 'none');
            var json = JSON.parse(data);
            if(json.res === 'error')
            {
                $('#err_name_editorial').html(json.name).css('display', 'block');
                $('#btn_update_editorial').attr("disabled", false);
            }else
            {
                console.log(json.rqst);
                if(json.rqst)
                {
                    $('#ok_name_editorial').html('La Editorial se Modifio Satisfactoriamente').css('display', 'block');
                    llenar_tabla_editoriales();
                    setTimeout(function()
                    {
                        $('#edit_editorial_modal').modal('hide')
                    }, 2000);
                }else
                {
                    $('#err_name_editorial').html('Error en la Base de Datos').css('display', 'block');
                }
            }
        },
        error: function(xhr)
        {
            $('#err_name_editorial').html('Error de Servidor '+ xhr).css('display', 'block');
        }
    });
    e.preventDefault();
});

/**
 * Peticion ajax generica para hacer una busqueda de un documento de acuerdo
 * al parametro de entrada query.
 * @param  {String} query            filtro de busqueda.
 * @param  {String} campo            url de la peticion("funcion en php qu atiende la peticion
 *                                   respondiendo con un mensaje o los datos solicitados").
 * @param  {String} function_success funcion llamada cuando la peticion tiene exito.
 * @param  {String} function_error   funcion llamada cuando la peticion falla.
 * @return {json}                    datos en formto json.
 */
function query_docs(query, campo, function_success, function_error)
{
    $.ajax({
            url: campo+query,
            type: 'GET',
            success: function_success,
            error: function_error
    });
}

/**
 * ----------------------------------------------------------------------------------------
 * ----------------------------------------------------------------------------------------
 * ---------------------------------Eventos------------------------------------------------
 * ----------------------------------------------------------------------------------------
 * ----------------------------------------------------------------------------------------
 */

/**
 * Evento que es disparado cuando se hace click sobre un link
 * de una tabla de resultados de autores, llama una ventana
 * modal de edicion de autores.
 * @param  {evento} e evento generado al hacer click.
 */
$('body').on('click', '#resultados_autors a', function(e){    
    var id_autor = $(this).data('id');
    var name_autor = $(this).data('name');
    var uri = base_url+'autores/update_rqst';
    $('#form_edit_autor').attr("action", uri+'/'+id_autor);
    $('#input_nombre_autor').val(name_autor);

    $('#edit_autor_modal').modal({
        keyboard: true
        //remote: $(this).attr('href')
    })
    e.preventDefault();
});

/**
 * Evento que es disparado cuando se hace click sobre un link
 * de una tabla de resultados de editoriales, llama una ventana
 * modal de edicion de editoriales.
 * @param  {evento} e evento generado al hacer click sobre un link.
 */
$('body').on('click', '#resultados_editoriales a', function(e){    
    var id_autor = $(this).data('id');
    var name_autor = $(this).data('name');
    var uri = base_url+'editoriales/update_rqst';
    $('#form_edit_editorial').attr("action", uri+'/'+id_autor);
    $('#input_nombre_editorial').val(name_autor);

    $('#edit_editorial_modal').modal({
        keyboard: true
    })
    e.preventDefault();
});

/**
 * Evento generado cuando se suelta una tecla sobre el campo
 * con id "#camp_query_autor", hace la peticion de busqueda de 
 * autores.
 * @param  {event} e.
 */
$('#camp_query_autor').on('keyup', function(e){
    var query = $(this).val();
    get_autores(query);
});

/**
 * Evento generado cuando se suelta una tecla sobre el campo
 * con id "#camp_query_editorial", hace la peticion de busqueda
 * de editoriales.
 * @param  {event} e.
 */
$('#camp_query_editorial').on('keyup', function(e){
    var query = $(this).val();
    get_editoriales(query);
});

/**
 * Evento generado cuando se suelta una tecla sobre el campo
 * con id "#camp_query_doc", si el tamano lenght de lo que se obtiene
 * del campo es menor de 2 no se hace la solicitud, este evento hace una
 * peticion de busqueda hecha por un usuario catalogador, hace uso de la 
 * funcion de peticion query_docs(query, url, funcion_success, funtion_error).
 * @param  {event} e.
 */
$('#camp_query_doc').on('keyup', function(e){
    var query = $(this).val();
    if(query.length > 2)
    {
        var campo = base_url+'libros/query_rqst/';
        query_docs(query, campo, res_docs_catalogador, function(xhr){console.log('error de servidor')});
    }
});

/**
 * Evento generado al hacer click sobre el boton buscar, se toma
 * el valor actual del campo con id "#camp_query_docs", este evento
 * hace la peticion de busqueda de documentos, qu hace un usuario normal.
 * @param  {event} e datos y valores del evento generado.
 * @return {void}   se hace una peticion ajax que trae los documentos
 * que coincidan con el valor del campo "#camp_query_docs", para esto hace
 * uso de la funcion de peticion query_docs(query, url, funcion_success, funtion_error).
 */
$('#btn_query_docs').on('click', function(e){
    var query = $('#camp_query_docs').val();
    if(query.length > 2)
    {
        var campo = base_url+'libros/query_rqst/';
        query_docs(query, campo, res_query_docs, function(xhr){console.log('error de servidor')});
    }
});

/**
 * Evento generado al cerrar la ventana modal con id
 * "#create_autor_modal".
 * @param  {enevnt} e 
 * @return {void}   se limpian campos del modal
 */
$('#create_autor_modal').on('hidden.bs.modal', function (e)
{
    $('#input_nombre_autor').val('');
    $('#err_name_autor').html('').css('display', 'none');
    $('#ok_name_autor').html('').css('display', 'none');
    $('#btn_create_autor').attr("disabled", false);
});

/**
 * Evento generado al cerrar la ventana modal con id
 * "#create_editorial_modal".
 * @param  {enevnt} e 
 * @return {void}   se limpian campos del modal
 */
$('#create_editorial_modal').on('hidden.bs.modal', function (e)
{
    $('#input_nombre_editorial').val('');
    $('#err_name_editorial').html('').css('display', 'none');
    $('#ok_name_editorial').html('').css('display', 'none');
    $('#btn_create_autor').attr("disabled", false);
});

/**
 * Evento generado al cerrar la ventana modal con id
 * "#edit_autor_modal".
 * @param  {enevnt} e 
 * @return {void}   se limpian campos del modal
 */
$('#edit_autor_modal').on('hidden.bs.modal', function (e)
{
    $('#input_nombre_autor').val('');
    $('#err_name_autor').html('').css('display', 'none');
    $('#ok_name_autor').html('').css('display', 'none');
    $('#btn_edit_autor').attr("disabled", false);
    //$('#edit_autor_modal .modal-content').html('');
});

/**
 * Evento generado al cerrar la ventana modal con id
 * "#edit_editorial_modal".
 * @param  {enevnt} e 
 * @return {void}   se limpian campos del modal
 */
$('#edit_editorial_modal').on('hidden.bs.modal', function (e)
{
    $('#input_nombre_editorial').val('');
    $('#err_name_editorial').html('').css('display', 'none');
    $('#ok_name_editorial').html('').css('display', 'none');
    $('#btn_update_editorial').attr("disabled", false);
});


/**
 * Evento generado cuando se hace click sobre un link de eliminacion de 
 * documento, este evento responde con la visializacion de un modal de confirmacion
 * para este fin llama a la funcion auxiliar mostrar_mensaje.
 * @param  {event} e  datos y valores del evento generado
 * @return {void}     depliegue de mensaje de confirmacion.
 */
$('#resultados_docs').on('click', '#eliminar_documento', function(e)
{
    e.preventDefault();
    var uri = $(this).attr('uri');
    mostrar_mensaje('Eliminar Documento',
                    'Seguro desea eliminar el documento seleccionado',
                    '<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>'+
                    '<a href="'+uri+'" class="btn btn-primary" role="button">Confirmar</a>');
});

/**
 * ----------------------------------------------------------------------------------------
 * ----------------------------------------------------------------------------------------
 * ----------------------------Auxiliares--------------------------------------------------
 * ----------------------------------------------------------------------------------------
 * ----------------------------------------------------------------------------------------
 */

function llenar_tabla_autores()
{
    get_autores('');
}

function llenar_tabla_editoriales()
{
    get_editoriales('');
}

function res_query_docs(data)
{
    var json = JSON.parse(data);
    var documentos = json.docs;
    if(json.res === 'success')
    {
        $('#resultados_docs table').html('').css('display', 'table');
        $('#resultados_docs #result-mensaje').html('').css('display', 'none');
        $('#resultados_docs table').append('<thead>'+
                                                '<tr>'+
                                                    '<th>Id</th>'+
                                                    '<th>Titulo P</th>'+
                                                    '<th>Titulo S</th>'+
                                                    '<th>Autor/es</th>'+
                                                    '<th>Idioma</th>'+
                                                    '<th>Descripción</th>'+
                                                    '<th>Editorial</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody>');
        $.each(documentos, function(index, valor)
        {
            var autores = valor[0];
            var nombres_autores = '';
            $.each(autores, function(key, value)
            {
                nombres_autores = nombres_autores+' <span>-'+value.nombre+'</span>';
            });

            $('#resultados_docs tbody').append('<tr>'+
                                            '<td>'+valor.id+'</td>'+
                                            '<td>'+valor.titulo_p+'</td>'+
                                            '<td>'+valor.titulo_s+'</td>'+                                                
                                            '<td>'+nombres_autores+'</td>'+
                                            '<td>'+valor.idioma+'</td>'+
                                            '<td>'+valor.descripcion+'</td>'+
                                            '<td>'+valor.nombre+'</td>'+                                                
                                        '</tr>'
                                        );
        });
        $('#resultados_docs table').append('</tbody>');
    }else if(json.res === 'no found')
    {
        $('#resultados_docs table').css('display', 'none');
        $('#resultados_docs #result-mensaje').html('Documento no encontrado!').css('display', 'block');
    }else
    {
        $('#resultados_docs table').css('display', 'none');
        $('#resultados_docs #result-mensaje').html('Error!').css('display', 'block');
    }
}

/**
 * Funcion success para la busqueda hecha por el catalogador.
 * @return {[type]} [description]
 */
function res_docs_catalogador(data)
{
    var json = JSON.parse(data);
    var url_accion_update = base_url+'libros/update/';
    var url_accion_delete = base_url+'libros/delete/';
    var atributos = "data-toggle='modal' data-target='#myModal'"; 
    var documentos = json.docs;
    console.log(json);  
    console.log(documentos);
    if(json.res === 'success')
    {
        $('#resultados_docs table').css('display', 'table');
        $('#resultados_docs #result-mensaje').css('display', 'none');
        $('#resultados_docs tbody').html('');
        $.each(documentos, function(index, valor)
        {
            var autores = valor[0];
            var nombres_autores = '';
            $.each(autores, function(key, value)
            {
                nombres_autores = nombres_autores+' <span>-'+value.nombre+'</span>';
            });

            $('#resultados_docs tbody').append('<tr>'+
                                                '<td>'+valor.id+'</td>'+
                                                '<td>'+valor.titulo_p+'</td>'+
                                                '<td>'+valor.titulo_s+'</td>'+                                                
                                                '<td>'+nombres_autores+'</td>'+
                                                '<td>'+valor.idioma+'</td>'+
                                                '<td>'+valor.descripcion+'</td>'+
                                                '<td>'+valor.nombre+'</td>'+
                                                '<td><a href="'+url_accion_update+valor.id+'">Modificar</a></td>'+
                                                '<td><a href="'+url_accion_delete+valor.id+'" '+atributos+'>ELiminar</a></td>'+
                                            '</tr>'
                                        );
        });
    }else if(json.res === 'no found')
    {
        $('#resultados_docs table').css('display', 'none');
        $('#resultados_docs #result-mensaje').html('Documento no encontrado!').css('display', 'block');
    }else
    {
        $('#resultados_docs table').css('display', 'none');
        $('#resultados_docs #result-mensaje').html('Error!').css('display', 'block');
    }
    
}

function mostrar_mensaje(title, body, footer)
{
    $('#modal_mensajes #modal_mensajesLabel').html(title);
    $('#modal_mensajes .modal-body').html(body);
    if(footer)
    {
        $('#modal_mensajes .modal-footer').html(footer);
    }else
    {
        $('#modal_mensajes .modal-footer').html('');
    }
    $('#modal_mensajes').modal('show');
}

function ocultar_mensaje()
{
    $('#modal_mensajes').modal('hide');
}

function success_query_autors(data)
{
    console.log(data);
    var url_accion = base_url+'autores/update/';
    var json = JSON.parse(data);
    if(json.res === 'success')
    {
        $('#result-mensaje').css('display', 'none'); 
        $('#resultados_autors table').css('display', 'table');
        $('#resultados_autors tbody').html('');
        $.each(json.datos, function(index, valor)
        {
            $('#resultados_autors tbody').append('<tr>'+
                                        '<td>'+valor.id+'</td>'+
                                        '<td>'+valor.nombre+'</td>'+
                                        '<td><a href="'+url_accion+valor.id+'" data-id="'+valor.id+'" data-name="'+valor.nombre+'">Modificar</a></td>'+                                    
                                    '</tr>'
                            );
        });//data-toggle="modal", data-target="#edit_autor_modal"
    }else
    {
        $('#resultados_autors table').css('display', 'none');
        $('#result-mensaje').html('Autor no encontrado').css('display', 'block');
    }
}

function success_query_editoriales(data)
{
    console.log(data);
    var url_accion = base_url+'editoriales/update_rqst';
    var json = JSON.parse(data);
    if(json.res === 'success')
    {
        $('#result-mensaje').css('display', 'none'); 
        $('#resultados_editoriales table').css('display', 'table');
        $('#resultados_editoriales tbody').html('');
        $.each(json.datos, function(index, valor)
        {
            $('#resultados_editoriales tbody').append('<tr>'+
                                        '<td>'+valor.id+'</td>'+
                                        '<td>'+valor.nombre+'</td>'+
                                        '<td><a href="'+url_accion+'" data-id="'+valor.id+'" data-name="'+valor.nombre+'">Modificar</a></td>'+                                    
                                    '</tr>'
                            );
        });//data-toggle="modal", data-target="#edit_autor_modal"
    }else
    {
        $('#resultados_editoriales table').css('display', 'none');
        $('#result-mensaje').html('Editorial no encontrado').css('display', 'block');
    }
}


function success_query_user(data)
{    
    var json = JSON.parse(data);//console.log(json);
    var usuarios = json.datos;
    var accion = $('#camp_query_user').attr('for');
    if(json.res === 'initial')
    {
        $('#resultados table').css('display', 'none');
        $('#result-mensaje').css('display', 'none');        
    }else if(json.res === 'success')
    {
        $('#result-mensaje').css('display', 'none'); 
        $('#resultados table').css('display', 'table');   
        llenar_tabla(usuarios, accion);
    }
    else
    {
        $('#resultados table').css('display', 'none');
        $('#result-mensaje').html('Usuario no encontrado').css('display', 'block');
    }
}

function llenar_tabla(data, accion)
{
    var n_accion;
    var url_accion = base_url+'usuarios/'+accion+'/';
    $('#resultados tbody').html('');
    if(accion === 'update')
    {
        n_accion = 'Modificar';
        $.each(data, function(index, valor)
        {
            $('#resultados tbody').append('<tr>'+
                                        '<td>'+valor.id+'</td>'+
                                        '<td>'+valor.nombre+'</td>'+
                                        '<td>'+valor.login+'</td>'+
                                        '<td>'+valor.telefono+'</td>'+
                                        '<td>'+valor.correo+'</td>'+
                                        '<td>'+valor.perfil+'</td>'+
                                        '<td><a href="'+url_accion+valor.id+'">'+n_accion+'</a></td>'+                                    
                                    '</tr>'
                            );
        });
    }
    else
    {
        n_accion = 'Eliminar';
        $.each(data, function(index, valor)
        {
            $('#resultados tbody').append('<tr>'+
                                        '<td>'+valor.id+'</td>'+
                                        '<td>'+valor.nombre+'</td>'+
                                        '<td>'+valor.login+'</td>'+
                                        '<td>'+valor.telefono+'</td>'+
                                        '<td>'+valor.correo+'</td>'+
                                        '<td>'+valor.perfil+'</td>'+
                                        '<td><a href="'+url_accion+valor.id+'" data-toggle="modal" data-target="#myModal">'+n_accion+'</a></td>'+                                    
                                    '</tr>'
                            );   
        });
    }
}

/*function direc_ajax(ruta, target){
	$.post('http://localhost/biblioteca/index.php/'+ruta, '', function(data)
    {
        $(target).html(data);
    });
}*/

});