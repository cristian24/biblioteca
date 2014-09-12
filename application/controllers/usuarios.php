<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
     * Carga la vista principal
     * @param  boolean $mensaje recibe un mensaje de exito o de fracaso, por defecto tiene
     *                          tiene un valor de false, por tanto no se envia ningun mensaje
     * @return void           Vista principal del modulo usuarios
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
     * llamdo ajax.
     * @param  boolean $query recibe el/los parametros de busqueda, por defecto no se envia nada.
     * @return json         datos en formata json
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
     * Carga la vista de busqueda de usuario
     * @param  String  $accion  Hace referencia a si la busqueda es para una actualización o una 
     *                          eliminación.
     * @param  boolean $mensaje mensaje de exito o de error, por defecto no se envia ningun mensaje.
     * @return void           se imprime la vista de busquda de usuarios.
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
     * Retorna datos en formato json, a un peticion ajax
     * @return json datos en format json
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
     * @param  boolean $mensaje Mensaje de exito o de fracaso, por defecto no se envia ningun mensaje.
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
     * Despliega un mensaje de confirmacion, si se responde con confirmar = true, se elimina la sesion
     * actual.
     * @param  boolean $confirmar valor de confirmacion true/false.
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
     * funcion auxiliar que crea las variables de sesion dependiendo de si $valor != invalid
     * @param  String $valor valid/invalid
     * @return void        se crean las variables de sesiones
     */
	public function user_valid($valor)
    {        
        if($valor !== 'invalid')
        {
            $arreglo_session = array(
                    'is_logued_in' => TRUE,                 
                    'username' => $valor['login'],
                    'perfil' => $valor['perfil']
                    );
            $this->session->set_userdata($arreglo_session);
            //redirect('home/index');
        }
    }   

    /**
     * Carga la vista de creacion de usuario o registro dependiendo de si $is_admin = true/false
     * si $is_admin es true es una creacion de usuario, si es false se asume como registro.
     * @param  boolean $is_admin true/false sirve como bandera para saber si sera un registro o una
     *                           creacion de usuario.
     * @return void            vista de creacion de usuarios o registro de usaurios
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
     * Carga la vista de actualización de usuarios
     * @param  integer  $id    Representa el id del usuario a actualizar
     * @param  boolean $is_ok bandera que se utiliza para saber si la actualizacion tuvo éxito
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
}

/* End of file usuarios.php */
/* Location: ./application/controllers/usuarios.php */