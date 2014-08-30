$(document).ready(function($) {
    var base_url = 'http://localhost/biblioteca/index.php/'
	$('#form_login').on('submit', function(e){

		$.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data)
            {
                var json = JSON.parse(data); 
                console.log(json); 
                             
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
                        $.post(base_url+'home/index_ajax', '', function(data)
                        {
                            $('#contenido').html(data);
                        });
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
});

function direc_ajax(ruta, target){
	$.post('http://localhost/biblioteca/index.php/'+ruta, '', function(data)
    {
        $(target).html(data);
    });
}