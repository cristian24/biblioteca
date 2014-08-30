<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model {

	public function __construct(){	
		//$this->load->library('database');	
		$this->load->database();
		$this->load->helper('security');		
	}

	public function get_user($login, $pass){
		$this->db->where(array('login' => $login, 'pass' => $pass));
		$query = $this->db->get('usuarios');
		if($query->num_rows() > 0)
        {
            return $query->row_array();
        }
        return 'invalid';
    }

    public function set_user($nombre, $telefono, $correo, $login, $pass, $perfil=FALSE){
    	if($perfil)
    	{
    		$data = array(
    				'nombre' => $nombre,
    				'login'  => $login,
    				'pass'	 => do_hash($pass, 'md5'),
    				'correo' => $correo,
    				'telefono' => $telefono,
    				'perfil' => $perfil
    			);
    		return $this->db->insert('usuarios', $data);
    	}else
    	{
    		$data = array(
    				'nombre' => $nombre,
    				'login'  => $login,
    				'pass'	 => do_hash($pass, 'md5'),
    				'correo' => $correo,
    				'telefono' => $telefono,
    				'perfil' => 'Usuario'
    			);
    		return $this->db->insert('usuarios', $data);
    	}
    }
}

/* End of file usuario_model.php */
/* Location: ./application/models/usuario_model.php */