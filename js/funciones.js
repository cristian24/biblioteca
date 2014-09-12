//$(document).ready(function($) {
//
var base_url = 'http://localhost/biblioteca/index.php/'

/**
 * Peticiones
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
        url: $(this).attr('uri')+'usuarios/query_rqst/'+query,
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

/**
 * Eventos
 */

$('#create_autor_modal').on('hidden.bs.modal', function (e)
{
    $('#input_nombre_autor').val('');
    $('#err_name_autor').html('').css('display', 'none');
    $('#ok_name_autor').html('').css('display', 'none');
    $('#btn_create_autor').attr("disabled", false);
});

$('#create_editorial_modal').on('hidden.bs.modal', function (e)
{
    $('#input_nombre_editorial').val('');
    $('#err_name_editorial').html('').css('display', 'none');
    $('#ok_name_editorial').html('').css('display', 'none');
    $('#btn_create_autor').attr("disabled", false);
});

/**
 * Auxiliares
 */

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


function success_query_user(data){    
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
    var url_accion = $('#camp_query_user').attr('uri')+'usuarios/'+accion+'/';
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