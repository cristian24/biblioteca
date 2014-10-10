<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador del módulo Usuarios, en esta clase se hacen y responden todas las peticiones
 * relacionadas con la gestión de Usuarios, se encarga de cargar la vista adecuada para cada 
 * petición, extiende del core del controller de codeigniter y carga el modelo de Usuarios.
 * @author Cristia Andres Cuspoca <cristian.cuspoca@correounivalle.edu.co>
 * @version 1.0
 */
class Usuarios extends CI_Controller {

    /**
     * Constructor
     */
	public function __construct()
    {
		parent::__construct();
		$this->load->model('usuario_model');
        $this->load->helper('security');		
	}

    /**
     * Carga la vista principal del módulo de usuarios.
     * @param  boolean $mensaje recibe un mensaje de éxito o de fracaso, por defecto tiene
     *                          tiene un valor de false, por tanto no se envía ningún mensaje
     * @return void             Vista principal del módulo usuarios.
     */
	public function index($mensaje=FALSE)
	{
		$this->session->acceso('Administrador');

        if($mensaje)
        {
            if($mensaje === 'ok')
            {
                $data['mensaje_ok'] = "<div class='alert alert-success alert-dismissible' role='alert'>
                                            <button type='button' class='close' data-dismiss='alert'>
                                                <span aria-hidden='true'>&times;</span>
                                                <span class='sr-only'>Close</span>
                                            </button>
                                            Usuario creado con exito!
                                        </div>";
                $data['mensaje_err'] = "";
            }               
            else
            {
                $data['mensaje_err'] = "<div class='alert alert-danger alert-dismissible' role='alert'>
                                            <button type='button' class='close' data-dismiss='alert'>
                                                <span aria-hidden='true'>&times;</span>
                                                <span class='sr-only'>Close</span>
                                            </button>
                                            Error! al crear usuario vuelve a 
                                            <a class='alert-link' href='../create/true'>intentarlo</a>.
                                        </div>";
                $data['mensaje_ok'] = "";
            }               
        }else
        {
            $data['mensaje_ok'] = "";
            $data['mensaje_err'] = "";
        }

		$data['title'] = 'Gesti&oacute;n Usuarios';
		$data['title_section'] = 'Gesti&oacute;n de Usuario';
		$data['subtitle_section'] = 'Gestiona usuarios y asigna perfiles';
		$data['libros_class'] = '';
		$data['usuario_class'] = 'active';
		$data['section_actual'] = 'Usuarios';
		$this->load->view('template/header', $data);
		$this->load->view('usuarios/usuarios', $data);
		$this->load->view('template/footer');	
	}

    /**
     * Retorna los datos del usuario consultado, se responde un json el cual es solicitado por un 
     * llamado ajax.
     * @param  boolean $query recibe el/los parámetros de búsqueda, por defecto no se envía nada.
     * @return json         datos en formato json.
     */
    public function query_rqst($query=FALSE)
    {
        if($this->input->is_ajax_request())
        {
            if( ! $query)
            {                
                $data = array(
                        'res' => 'initial'
                );
            }else
            {
                $peticion = $this->usuario_model->get_user_login($query);
                if($peticion === 'no found')
                {
                    $data = array(
                        'res' => 'no found'
                    );
                }else
                {
                    $data = array(
                        'res' => 'success',
                        'datos' => $peticion
                    );
                }
            }          
            echo json_encode($data);
        }
        else
        {
            show_404();
        }
    }

    /**
     * Carga la vista de búsqueda de usuario
     * @param  String  $accion  Hace referencia a si la búsqueda es para una actualización o una 
     *                          eliminación.
     * @param  boolean $mensaje de éxito o de error, por defecto no se envía ningún mensaje.
     * @return void           se imprime la vista de búsqueda de usuarios.
     */
    public function query($accion, $mensaje=FALSE)
    {
        if($accion === 'update' || $accion === 'delete')
        {
            if($mensaje)
            {
                if($mensaje === 'ok')
                {
                    $data['mensaje_ok'] = "<div class='alert alert-success alert-dismissible' role='alert'>
                                                <button type='button' class='close' data-dismiss='alert'>
                                                    <span aria-hidden='true'>&times;</span>
                                                    <span class='sr-only'>Close</span>
                                                </button>
                                                Usuario Eliminado con exito!
                                            </div>";
                    $data['mensaje_err'] = "";
                }               
                else
                {
                    $data['mensaje_err'] = "<div class='alert alert-danger alert-dismissible' role='alert'>
                                                <button type='button' class='close' data-dismiss='alert'>
                                                    <span aria-hidden='true'>&times;</span>
                                                    <span class='sr-only'>Close</span>
                                                </button>
                                                Error! al crear usuario vuelve a 
                                                <a class='alert-link' href='../create/true'>intentarlo</a>.
                                            </div>";
                    $data['mensaje_ok'] = "";
                }               
            }else
            {
                $data['mensaje_ok'] = "";
                $data['mensaje_err'] = "";
            }
            if($accion === 'update')
            {
                $data['title'] = 'Modificar Usuario';
                $data['title_section'] = 'Modificar Usuario';
                $data['user_edit_class'] = 'active';
                $data['user_delete_class'] = '';
                $data['section_actual'] = 'Modificar Usuario';
                $data['subtitle_section'] = 'Digita su nombre o login y presiona Modificar';
            }else
            {
                $data['title'] = 'Eliminar Usuario';
                $data['title_section'] = 'Eliminar Usuario';
                $data['user_edit_class'] = '';
                $data['user_delete_class'] = 'active';
                $data['section_actual'] = 'Eliminar Usuario';
                $data['subtitle_section'] = 'Digita su nombre o login y presiona Eliminar';
            }            
            $data['libros_class'] = '';
            $data['usuario_class'] = 'active';
            $data['user_create_class'] = '';        
            $data['user_query_class'] = '';        
            $data['login_class'] = '';        
            $data['for'] = $accion;
            $this->load->view('template/header', $data);
            $this->load->view('usuarios/query_user', $data);
            $this->load->view('template/footer');
        }
        else
        {
            show_404();
        }
         
    }

    /**
     * Retorna datos en formato json, a un petición ajax
     * @return json datos en format json.
     */
	public function login_rqst()
    {
		if($this->input->is_ajax_request())
        {            
            $this->form_validation->set_rules('login', 'Login', 'trim|required|min_length[3]|max_length[50]|xss_clean');
        	$this->form_validation->set_rules('pass', 'Pass', 'trim|required|min_length[3]|max_length[30]|xss_clean');
                   
        	if($this->form_validation->run() === FALSE)
        	{
        	   $data = array(
                    'login'     =>      form_error('login'),
                    'pass'      =>    	form_error('pass'),
                    'res'       =>      'error'
               );        
        	}else
        	{        	   
               $login = $this->input->post('login');
               $pass = do_hash($this->input->post('pass'), 'md5');
        	   $peticion = $this->usuario_model->get_user($login, $pass);       	   
        	   $data = array(
                    'res'       =>      'succes',
                    'datos'		=>		$peticion
               );
               $this->user_valid($peticion);               
        	}            
            echo json_encode($data);            
        }else
        {
            show_404();
        }
	}

    /**
     * Carga la vista de logeo
     * @param  boolean $mensaje Mensaje de éxito o de fracaso, por defecto no se envía ningún mensaje.
     * @return void           se imprime la vista de logeo.
     */
	public function login($mensaje=FALSE){
		$this->session->is_logueado();

        if($mensaje)
        {
            if($mensaje === 'ok')
            {
                $data['mensaje_ok'] = "<div class='alert alert-success alert-dismissible' role='alert'>
                                            <button type='button' class='close' data-dismiss='alert'>
                                                <span aria-hidden='true'>&times;</span>
                                                <span class='sr-only'>Close</span>
                                            </button>
                                            Se registro con exito! porfavor inicia sesion
                                        </div>";
                $data['mensaje_err'] = "";
            }               
            else
            {
                $data['mensaje_err'] = "<div class='alert alert-danger alert-dismissible' role='alert'>
                                            <button type='button' class='close' data-dismiss='alert'>
                                                <span aria-hidden='true'>&times;</span>
                                                <span class='sr-only'>Close</span>
                                            </button>
                                            Error! al registrarse vuelve a
                                            <a class='alert-link' href='../create'>intentarlo</a>.
                                        </div>";
                $data['mensaje_ok'] = "";
            }               
        }else
        {
            $data['mensaje_ok'] = "";
            $data['mensaje_err'] = "";
        }

    	$data['title'] = 'Inicio Sesion';
		$data['title_section'] = 'Inicia Sesion';
		$data['subtitle_section'] = 'Inicia sesion para obtener acceso a las descargas';
		$data['libros_class'] = '';
		$data['usuario_class'] = '';
		$data['login_class'] = 'active';
		$data['section_actual'] = 'Login';
		$this->load->view('template/header', $data);
		$this->load->view('usuarios/login', $data);
		$this->load->view('template/footer');	
	}

    /**
     * Despliega un mensaje de confirmación, si se responde con confirmar = true, se elimina la sesión
     * actual.
     * @param  boolean $confirmar valor de confirmación true/false.
     * @return void             imprime mensaje de confirmación.
     */
    public function salir($confirmar=FALSE)
    {
        if($confirmar)
        {
            $this->session->sess_destroy();
            redirect('');
        }else
        {
            $data['link'] = base_url().'index.php/usuarios/salir/true';
            $this->load->view('usuarios/salir', $data);
        }        
    }

    /**
     * Función auxiliar que crea las variables de sesión dependiendo de si $valor != invalid
     * @param  String $valor valid/invalid
     * @return void        se crean las variables de sesiones.
     */
	public function user_valid($valor)
    {        
        if($valor !== 'invalid')
        {
            $arreglo_session = array(
                    'is_logued_in' => TRUE,                 
                    'username' => $valor['login'],
                    'perfil' => $valor['perfil'],
                    'id_user' => $valor['id']
                    );
            $this->session->set_userdata($arreglo_session);
            //redirect('home/index');
        }
    }   

    /**
     * Carga la vista de creación de usuario o registro dependiendo de si $is_admin = true/false
     * si $is_admin es true es una creación de usuario, si es false se asume como registro.
     * @param  boolean $is_admin true/false sirve como bandera para saber si será un registro o una
     *                           creación de usuario.
     * @return void            vista de creación de usuarios o registro de usuarios.
     */
    public function create($is_admin = FALSE)
    {        
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[3]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('login', 'Login', 'trim|required|min_length[3]|max_length[50]|is_unique[usuarios.login]');
        $this->form_validation->set_rules('pass', 'Contraseña', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('pass2', 'Repetir Contraseña', 'required|matches[pass]');
        $this->form_validation->set_rules('correo', 'Correo', 'trim|required|max_length[100]|valid_email|is_unique[usuarios.correo]');
        $this->form_validation->set_rules('telefono', 'Telefono', 'trim|required|numeric|min_length[6]|max_length[10]');
        if($is_admin)
        {
            $this->session->acceso('Administrador');
            $this->form_validation->set_rules('perfil', 'Perfil', 'trim|required');
        }

        if($this->form_validation->run() === FALSE)
        {
            $data['libros_class'] = '';
            $data['user_create_class'] = 'active';
            $data['user_delete_class'] = '';
            $data['user_query_class'] = '';
            $data['user_edit_class'] = '';
            $data['login_class'] = '';
            if($is_admin)
            {
                $data['title'] = 'BiblioCristian';
                $data['title_section'] = 'Crear Usuario';
                $data['subtitle_section'] = 'Cree un usuario con el perfil que quiera';                
                $data['usuario_class'] = 'active';
                $data['section_actual'] = 'Crear Usuario';
                $data['is_admin'] = TRUE;
                $this->load->view('template/header', $data);
                $this->load->view('usuarios/create_user', $data);
                $this->load->view('template/footer');
            }else
            {
                $data['title'] = 'Crear Cuenta';
                $data['title_section'] = 'Crear Cuenta';
                $data['subtitle_section'] = 'Cree una cuenta, para poder descargar';                
                $data['usuario_class'] = '';        
                $data['section_actual'] = 'Crear Cuenta';
                $data['is_admin'] = FALSE;
                $this->load->view('template/header', $data);
                $this->load->view('usuarios/create_user', $data);
                $this->load->view('template/footer');
            }
        }else
        {
            $nombre = $this->input->post('nombre');
            $login = $this->input->post('login');
            $pass = $this->input->post('pass');
            $correo = $this->input->post('correo');
            $telefono = $this->input->post('telefono');
            $perfil = $this->input->post('perfil');
            if($is_admin)
            {                
                $response = $this->usuario_model->set_user($nombre, $telefono, $correo, $login, $pass, $perfil);
                if($response)
                {
                    redirect('usuarios/index/ok');
                }else
                {
                    redirect('usuarios/index/err');
                }                    
            }else
            {
                $response = $this->usuario_model->set_user($nombre, $telefono, $correo, $login, $pass, FALSE);
                if($response)
                {
                    redirect('usuarios/login/ok');
                }else
                {
                    redirect('usuarios/login/err');
                }                
            }
        }       
    }

    /**
     * Función que carga la vista de actualización de información del usuario logueado
     * después de validados los datos se hace la petición al modelo de actualización 
     * si esta no falla se redirige de nuevo a esta función pero con el valor que entra 
     * como parámetro a true(esta bandera imprime un mensaje de éxito).
     * @param  boolean $is_ok bandera que imprime mensaje de éxito
     * @return void         Renderizado de la vista de actualización de info.
     */
    function update_info($is_ok=FALSE)
    {
        $id = $this->session->userdata('id_user');
        $this->session->acceso('Usuario');
        $usuario = $this->usuario_model->get_user_id($id);
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[3]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('login', 'Login', 'trim|required|min_length[3]|max_length[50]');        
        $this->form_validation->set_rules('correo', 'Correo', 'trim|required|max_length[100]|valid_email');
        $this->form_validation->set_rules('telefono', 'Telefono', 'trim|required|numeric|min_length[6]|max_length[10]');        

        $this->form_validation->set_value('nombre', $usuario['nombre']);
        $this->form_validation->set_value('login', $usuario['login']);

        if($this->form_validation->run() === FALSE)
        {
            $data['libros_class'] = '';
            $data['usuario_class'] = '';
            $data['title'] = 'Actualizar Información';
            $data['title_section'] = 'Actualiza tus Datos';
            $data['subtitle_section'] = 'Actualiza tus datos personales';
            $data['usuario_class'] = 'active';
            $data['section_actual'] = 'Actualiza tus Datos';
            $data['usuario'] = $usuario;
            $data['id_usuario'] = $id;
            if($is_ok)
                $data['mensaje_ok'] = TRUE;
            else
                $data['mensaje_ok'] = FALSE;

            $this->load->view('template/header', $data);
            $this->load->view('usuarios/update_info', $data);
            $this->load->view('template/footer');
        }else
        {
            $nombre = $this->input->post('nombre');
            $login = $this->input->post('login');
            $correo = $this->input->post('correo');
            $telefono = $this->input->post('telefono');
            $response = $this->usuario_model->update_user($id, $nombre, $correo, $login, $telefono);
            redirect('usuarios/update_info/true');
        }
    }

    /**
     * Carga la vista de actualización de usuarios
     * @param  integer  $id    Representa el id del usuario a actualizar
     * @param  boolean $is_ok bandera que se utiliza para saber si la actualización tuvo éxito
     * @return void        se imprime la vista de actualización de usuario.
     */
    public function update($id, $is_ok=FALSE)
    {
        $this->session->acceso('Administrador');
        $usuario = $this->usuario_model->get_user_id($id);
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[3]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('login', 'Login', 'trim|required|min_length[3]|max_length[50]');        
        $this->form_validation->set_rules('correo', 'Correo', 'trim|required|max_length[100]|valid_email');
        $this->form_validation->set_rules('telefono', 'Telefono', 'trim|required|numeric|min_length[6]|max_length[10]');
        $this->form_validation->set_rules('perfil', 'Perfil', 'trim|required');

        $this->form_validation->set_value('nombre', $usuario['nombre']);
        $this->form_validation->set_value('login', $usuario['login']);

        if($this->form_validation->run() === FALSE)
        {
            $data['title'] = 'Modificar Usuario';
            $data['title_section'] = 'Modificar Usuario';
            $data['subtitle_section'] = '';
            $data['libros_class'] = '';
            $data['user_create_class'] = '';
            $data['user_delete_class'] = '';
            $data['user_query_class'] = '';
            $data['user_edit_class'] = 'active';
            $data['login_class'] = '';                     
            $data['usuario_class'] = 'active';
            $data['section_actual'] = $usuario['id'];            
            $data['usuario'] = $usuario;
            $data['administrador'] = FALSE;
            $data['catalogador'] = FALSE;
            $data['dafault'] = FALSE;
            if($is_ok)
                $data['mensaje_ok'] = TRUE;
            else
                $data['mensaje_ok'] = FALSE;
            if($usuario['perfil'] === 'Administrador')
                $data['administrador'] = TRUE;
            else if($usuario['perfil'] === 'Catalogador')
                $data['catalogador'] = TRUE;
            else
                $data['dafault'] = TRUE;

            $this->load->view('template/header', $data);
            $this->load->view('usuarios/update_user', $data);
            $this->load->view('template/footer');            
        }else
        {            
            $nombre = $this->input->post('nombre');
            $login = $this->input->post('login');
            $pass = $this->input->post('pass');
            $correo = $this->input->post('correo');
            $telefono = $this->input->post('telefono');
            $perfil = $this->input->post('perfil');            
            $response = $this->usuario_model->update_user($id, $nombre, $correo, $login, $telefono, $perfil); 
            redirect('usuarios/update/'.$id.'/true');           
        }
    }

    /**
     * Carga mensaje de confirmación para eliminar o no un usuario específico.
     * @param  integer  $id        usuario a eliminar
     * @param  boolean $confirmar true se elimina el usuario, false no se hace nada
     * @return void             despliegue de mensaje.
     */
    public function delete($id, $confirmar=FALSE)
    {
        $this->session->acceso('Administrador');
        if($confirmar)
        {
            $response = $this->usuario_model->delete_user($id);
            if($response)
                redirect('usuarios/query/delete/ok');
            else
                redirect('usuarios/query/delete/err');
        }        
        $data['link'] = base_url().'index.php/usuarios/delete/'.$id.'/true';
        $this->load->view('usuarios/delete_user', $data);
    }

    /**
     * Caraga vista de actualización de pass.
     * @return void
     */
    public function update_pass()
    {
        $id = $this->session->userdata('id_user');
        $data['libros_class'] = '';
        $data['usuario_class'] = '';
        $data['title'] = 'Modificar Contraseña';
        $data['title_section'] = 'Modificar Contraseña';
        $data['subtitle_section'] = 'Modifica tu contraseña de usuario';
        $data['usuario_class'] = '';
        $data['section_actual'] = 'Modificar Contraseña';
        $data['usuario'] = $this->usuario_model->get_user_id($id);
        $this->load->view('template/header', $data);
        $this->load->view('usuarios/update_pass', $data);
        $this->load->view('template/footer');       
    }

    /**
     * Envió y recepción de petición ajax de actualización de pass.
     * @return json     Respuesta a través de json.
     */
    public function update_pass_rqst()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('pass_last', 'Contraseña Actual', 'trim|required');
            $this->form_validation->set_rules('pass', 'Contraseña', 'trim|required|min_length[3]|max_length[50]');
            $this->form_validation->set_rules('pass2', 'Repetir Contraseña', 'required|matches[pass]');
                   
            if($this->form_validation->run() === FALSE)
            {
                $data = array(
                    'pass_last' =>      form_error('pass_last'),
                    'pass'      =>      form_error('pass'),
                    'pass2'     =>      form_error('pass2'),
                    'res'       =>      'error'
                );
                echo json_encode($data);
            }else
            {
                $id = $this->session->userdata('id_user');
                $usuario = $this->usuario_model->get_user_id($id);
                $pass_actual = $usuario['pass'];
                $pass_last = do_hash($this->input->post('pass_last'), 'md5');                
                
                //se compara lo guadado en la base de datos y lo que el usuario
                //digita como verificacion de la contraseña actual
                if($pass_last === $pass_actual)
                {
                    //si entra aquí se procede a actualizar la contraseña
                    $pass = do_hash($this->input->post('pass'), 'md5');
                    $response = $this->usuario_model->update_pass($id, $pass);
                    $data = array(
                        'res'           =>      'succes',
                        'response'     =>      $response
                    );
                    echo json_encode($data);
                }else
                {
                    $data = array(
                        'res'       =>  'no equal',
                        'mensaje'   =>  'No corresponde a su contrasena Actual, porfavor digitela de nuevo'
                    );
                    echo json_encode($data);
                    return false;
                }
            }
        }else
        {
            show_404();
        }
    }

    public function recover_data($is_pass=FALSE)
    {
        if($is_pass)
        {
            $id = $this->session->userdata('id_user');
            $data['libros_class'] = '';
            $data['usuario_class'] = '';
            $data['title'] = 'Recuperar Contraseña';
            $data['title_section'] = 'Recuperar Contraseña';
            $data['subtitle_section'] = 'Verifica tu correo, para continuar';
            $data['usuario_class'] = '';
            $data['section_actual'] = 'Recuperación Contraseña';
            if(empty($id))
            {
                $data['usuario'] = FALSE;
            }else
            {
                $data['usuario'] = $this->usuario_model->get_user_id($id);
            }            
            $data['type_recover'] = 'pass';

            $this->form_validation->set_rules('correo', 'Correo', 'trim|required|max_length[100]|valid_email');
            if($this->form_validation->run() === FALSE)
            {
                $this->load->view('template/header', $data);
                $this->load->view('usuarios/recover_data', $data);
                $this->load->view('template/footer');
            }else
            {
                $correo = $this->input->post('correo');
                $datos = $this->usuario_model->get_pass_login($correo);
                
                if( ! empty($datos))
                {
                    $this->load->library('email');
                    //la configuración del correo del que envia se encuentra en el archivo de configuración
                    // /application/config/email.php
                    $this->email->from('BiblioCristian');
                    $this->email->to($correo);
                    $this->email->subject('Recuperacion de Contraseña');
                    $this->email->message('<h1>Recuperación de Contraseña BiblioCristian</h1>'.
                                          '<strong>Hola, '.$datos['login'].':</strong>'.
                                          '<p>Recientemente solicitaste la recuperación de tú contraseña '.
                                          'para continuar con el proceso has click '.
                                          '<a href="'.base_url().'index.php/usuarios/recover_pass/'.$datos['id'].'/'.$datos['code'].'">aquí</a>.</p>'.
                                          '<p>Tenga en cuenta que este enlace funcionara solo una vez. '.
                                          'Si tú no has realizado esta petición simplemente ignora este mensaje '.
                                          'te recordamos cambiar tu clave regularmente.</p>'.
                                          'Atentamente<br>'.
                                          'Equipo BiblioCristian');
                    if($this->email->send())
                    {
                        $data['mensaje_ok'] = 'Se ha enviado un mensaje a tu correo, '.
                                            'revisalo y accede en el enlace para continuar con el proceso';
                    }else
                    {
                        $data['mensaje_err'] = 'Se presento un error enviando el correo,'.
                                                ' porfavor intenetelo de nuevo';
                    }                    
                    //echo $this->email->print_debugger(); //descomentar para el debuger   

                    $this->load->view('template/header', $data);
                    $this->load->view('usuarios/recover_data', $data);
                    $this->load->view('template/footer');
                }else
                {
                    $data['mensaje_err'] = 'Este correo no esta registrado, verifique que este bien escrito';
                    $this->load->view('template/header', $data);
                    $this->load->view('usuarios/recover_data', $data);
                    $this->load->view('template/footer');
                }
            }
        }else
        {
            //Recuperacion de Login
            $data['libros_class'] = '';
            $data['usuario_class'] = '';
            $data['title'] = 'Recuperar Login';
            $data['title_section'] = 'Recuperar Login';
            $data['subtitle_section'] = 'Ingresar correo asociado a esta cuenta';
            $data['usuario_class'] = '';
            $data['section_actual'] = 'Recuperación Login';
            $data['usuario'] = FALSE;          
            $data['type_recover'] = 'login';
            $this->form_validation->set_rules('correo', 'Correo', 'trim|required|max_length[100]|valid_email');
            if($this->form_validation->run() === FALSE)
            {
                $this->load->view('template/header', $data);
                $this->load->view('usuarios/recover_data', $data);
                $this->load->view('template/footer');
            }else
            {
                $correo = $this->input->post('correo');
                $datos = $this->usuario_model->get_pass_login($correo);
                
                if( ! empty($datos))
                {
                    //codigo de como enviar el email extraido desde
                    
                    $this->email->from('BiblioCristian');
                    $this->email->to($correo);
                    $this->email->subject('Recuperacion de Login');
                    $this->email->message('<h1>Recuperación de Contraseña BiblioCristian</h1>'.
                                          '<strong>Hola, '.$datos['login'].':</strong>'.
                                          '<p>Recientemente solicitaste la recuperación de tú Login. '.
                                          'Estos son los Datos de tu cuenta</p> '.
                                          '<p><strong>Login:</strong> '.$datos['login'].'</p>'.
                                          '<p>Si tú no has realizado esta petición simplemente ignora este mensaje '.
                                          'te recordamos cambiar tu clave regularmente.</p>'.
                                          'Atentamente<br>'.
                                          'Equipo BiblioCristian');
                    if($this->email->send())
                    {
                        $data['mensaje_ok'] = 'Se ha enviado un mensaje a tu correo, con los datos de tu cuenta '.
                                            'revisalo e intenta acceder de nuevo';
                    }else
                    {
                        $data['mensaje_err'] = 'Se presento un error enviando el correo,'.
                                                ' porfavor intenetelo de nuevo';
                    }
                    $this->load->view('template/header', $data);
                    $this->load->view('usuarios/recover_data', $data);
                    $this->load->view('template/footer');
                }else
                {
                    $data['mensaje_err'] = 'Este correo no esta registrado, verifique que este bien escrito';
                    $this->load->view('template/header', $data);
                    $this->load->view('usuarios/recover_data', $data);
                    $this->load->view('template/footer');
                }
            }
        }
    }

    public function recover_pass($id, $code)
    {
        $peticion_valida = $this->usuario_model->get_code($code, $id);
        if(empty($peticion_valida))
        {
            redirect('restringido');
        }
        $data['libros_class'] = '';
        $data['usuario_class'] = '';
        $data['title'] = 'Recuperar Contraseña';
        $data['title_section'] = 'Recuperar Contraseña';
        $data['subtitle_section'] = 'Crea la nueva Contraseña';
        $data['usuario_class'] = '';
        $data['section_actual'] = 'Recuperar Contraseña';
        $data['id'] = $id;
        $data['code'] = $code;
        $this->form_validation->set_rules('pass', 'Contraseña', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('pass2', 'Repetir Contraseña', 'trim|required|matches[pass]');
        if($this->form_validation->run() === FALSE)
        {
            $this->load->view('template/header', $data);
            $this->load->view('usuarios/recover_pass', $data);
            $this->load->view('template/footer');
        }else
        {
            $pass = $this->input->post('pass');
            $response = $this->usuario_model->update_pass($id,$pass);
            if( ! empty($response))
            {
                $data['mensaje_ok'] = 'Contraseña Actualizada, Accede de nuevo con esta Contraseña';
                $this->usuario_model->update_code($id, $code);
                $this->load->view('template/header', $data);
                $this->load->view('usuarios/recover_pass', $data);
                $this->load->view('template/footer');
                $this->session->sess_destroy();
            }else
            {
                $data['mensaje_err'] = 'Se presento un error actualizando la contraseña, debera '.
                                        'Realizar todo el procedimiento de nuevo.';
                $this->load->view('template/header', $data);
                $this->load->view('usuarios/recover_pass', $data);
                $this->load->view('template/footer');
                $this->session->sess_destroy();
            }
        }
    }
}

/* End of file usuarios.php */
/* Location: ./application/controllers/usuarios.php */