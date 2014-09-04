//$(document).ready(function($) {
var base_url = 'http://localhost/biblioteca/index.php/'
$('#form_login').on('submit', function(e){

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
            
            if(json.res == 'error')
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
            {
                if(json.datos == 'invalid')
                {
                    $('#user_invalid').append('Login/Pass Incorrectos').css('display','block');
                }else
                {
                    $('body').load(base_url+'home/index');
                    
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
    
//});


$('#camp_query_user').on('keyup', function(e){
    var query = $(this).val();
    $.ajax({
        url: $(this).attr('uri')+'usuarios/query_rqst/'+query,
        type: 'POST',
        success: success_query_user,
        error: function(){}
    });    
});


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