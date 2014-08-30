<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->model('usuario_model');
        $this->load->helper('security');		
	}

	public function index()
	{
		$this->session->acceso('Administrador');
		$data['title'] = 'Gesti&oacute;n Usuarios';
		$data['title_section'] = 'Gesti&oacute;n de Usuario';
		$data['subtitle_section'] = 'Gestiona Usuarios, Perfiles y Permisos';
		$data['libros_class'] = '';
		$data['usuario_class'] = 'active';
		$data['section_actual'] = 'Usuarios';
		$this->load->view('template/header', $data);
		$this->load->view('usuarios', $data);
		$this->load->view('template/footer');	
	}

	public function login_rqst()
    {
		if($this->input->is_ajax_request())
        {            
            $this->form_validation->set_rules('login', 'Login', 'trim|required|min_length[3]|max_length[50]|xss_clean');
        	$this->form_validation->set_rules('pass', 'Pass', 'trim|required|min_length[3]|max_length[30]|xss_clean');
            //personalizar mensajes.
            $this->form_validation->set_message('required', 'El campo %s es Requerido');
            $this->form_validation->set_message('min_length', 'El campo %s debe ser mayor de %s caracteres');  
            $this->form_validation->set_message('max_length', 'El campo %s debe ser menor de %s caracteres');      
        
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

	public function login(){
		$this->session->is_logueado('is_logued_in');

    	$data['title'] = 'Inicio Sesion';
		$data['title_section'] = 'Inicia Sesion';
		$data['subtitle_section'] = 'Inicia sesion para obtener acceso a las descargas';
		$data['libros_class'] = '';
		$data['usuario_class'] = '';
		$data['login_class'] = 'active';
		$data['section_actual'] = 'Login';
		$this->load->view('template/header', $data);
		$this->load->view('login', $data);
		$this->load->view('template/footer');	
	}

    public function salir(){
        $this->session->sess_destroy();
        redirect('');
    }

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
            $this->form_validation->set_rules('perfil', 'Perfil', 'trim|required');
        }
        //personalizar mensajes.
        $this->form_validation->set_message('required', 'El campo %s es Requerido');
        $this->form_validation->set_message('min_length', 'El campo %s debe ser mayor de %s caracteres');  
        $this->form_validation->set_message('max_length', 'El campo %s debe ser menor de %s caracteres');
        $this->form_validation->set_message('is_unique', 'Lo digitado en el campo %s ya existe');
        $this->form_validation->set_message('valid_email', 'No es un correo valido');
        $this->form_validation->set_message('numeric', 'El campo %s debe ser numerico 0..9');
        $this->form_validation->set_message('matches', 'El campo %s no coincide con el campo %s');
        


        if($this->form_validation->run() === FALSE)
        {
            if($is_admin)
            {
                $data['title'] = 'BiblioCristian';
                $data['title_section'] = 'Crear Usuario';
                $data['subtitle_section'] = 'Cree un usuario con el perfil que quiera';
                $data['libros_class'] = '';
                $data['usuario_class'] = 'active';
                $data['user_create_class'] = 'active';
                $data['user_delete_class'] = '';
                $data['user_query_class'] = '';
                $data['user_edit_class'] = '';
                $data['login_class'] = '';
                $data['section_actual'] = 'Crear Usuario';
                $data['is_admin'] = TRUE;
                $this->load->view('template/header', $data);
                $this->load->view('create_user', $data);
                $this->load->view('template/footer');
            }else
            {
                $data['title'] = 'Crear Cuenta';
                $data['title_section'] = 'Crear Cuenta';
                $data['subtitle_section'] = 'Cree una cuenta, para poder descargar';
                $data['libros_class'] = '';
                $data['usuario_class'] = '';
                $data['user_create_class'] = 'active';
                $data['user_delete_class'] = '';
                $data['user_query_class'] = '';
                $data['user_edit_class'] = '';
                $data['login_class'] = '';
                $data['section_actual'] = 'Crear Cuenta';
                $data['is_admin'] = FALSE;
                $this->load->view('template/header', $data);
                $this->load->view('create_user', $data);
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
                $this->usuario_model->set_user($nombre, $telefono, $correo, $login, $pass, $perfil);
            }else
            {
                $this->usuario_model->set_user($nombre, $telefono, $correo, $login, $pass, FALSE);
            }
        }

        
    }
}

/* End of file usuarios.php */
/* Location: ./application/controllers/usuarios.php */