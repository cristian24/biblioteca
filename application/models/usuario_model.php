<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo del modulo usuario, en esta clase se hacen todas las consultas
 * relacionadas con la gestion de usuarios, extiende del core del modelo
 * de codeigniter, carga la base de datos y la helper de seguridad.
 * @author Cristia Andres Cuspoca <cristian.cuspoca@hotmail.com>
 * @version 1.2
 */
class Usuario_model extends CI_Model {

    /**
     * Constructor del modelo, carga la libreria security
     */
	public function __construct()
    {
		$this->load->database();
		$this->load->helper('security');		
	}

    public function get_user_id($id)
    {
        $this->db->where(array('id' => $id));
        $query = $this->db->get('usuarios');
        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }
    }

    /**
     * Consulta para obtener uno y solo un usuario.
     * @param  [String] $login login del usaurio buscado.
     * @param  [String] $pass  contraseña del usuario buscado.
     * @return [String/array(usuario)]        si se encuentra el usuario
     *                                        se retornan un array con 
     *                                        sus datos, caso contrario 
     *                                        se retorna un mensaje.
     */
	public function get_user($login, $pass)
    {
		$this->db->where(array('login' => $login, 'pass' => $pass));
		$query = $this->db->get('usuarios');
		if($query->num_rows() > 0)
        {
            return $query->row_array();
        }
        return 'invalid';
    }

    /**
     * Consulta para obtener usuario de acuerdo a su nombre
     * se hace un like para hacer la busqueda por nombre o login.
     * @param  [String] $login Alusivo al login o nombre del usuario
     *                         Buscado.
     * @return [array(Usuarios)/String]        Si la consulta arroja
     *                                         resultados, se retorna
     *                                         la informacion del usuario
     *                                         caso contrario, se retorna un
     *                                         mensaje.
     */
    public function get_user_login($login)
    {
        $this->db->or_like('login', $login);
        $this->db->or_like('nombre', $login);
        $query = $this->db->get('usuarios'); 
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        return 'no found';
    }

    /**
     * Consulta para crear un usuario.
     * @param [String]  $nombre   nombre del usaurio
     * @param [String]  $telefono telefono del usaurio
     * @param [String]  $correo   correo del usaurio
     * @param [String]  $login    login del usaurio
     * @param [String]  $pass     pass del usaurio
     * @param [boolean] $perfil   perfil del usaurio
     */
    public function set_user($nombre, $telefono, $correo, $login, $pass, $perfil=FALSE)
    {
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

    /**
     * Actualiza la información de un usuario.
     * @param  [String]  $id       id del usuario a actualizar.
     * @param  [String]  $nombre   nombre nuevo.
     * @param  [String]  $correo   correo nuevo.
     * @param  [String]  $login    login nuevo.
     * @param  [String]  $telefono telefono nuevo.
     * @param  [boolean] $perfil   perfil nuevo, si no se
     *                           envia nada, se asume que la
     *                           actualizacion la hace un 
     *                           usuario normal, si por el 
     *                           contrario se envia algo se 
     *                           asume actualizacion por 
     *                           parte de un administrador.
     * @return [void]            Informacion actualizada
     */
    public function update_user($id, $nombre, $correo, $login, $telefono, $perfil=FALSE)
    {
        if($perfil)
        {
            $data = array(
                    'nombre' => $nombre,
                    'login'  => $login,
                    'correo' => $correo,
                    'telefono' => $telefono,
                    'perfil' => $perfil
                );
            $this->db->where('id', $id);
            $this->db->update('usuarios', $data); 
        }else
        {
            $data = array(
                    'nombre' => $nombre,
                    'login'  => $login,
                    'correo' => $correo,
                    'telefono' => $telefono
                );
            $this->db->where('id', $id);
            $this->db->update('usuarios', $data); 
        }
    }

    /**
     * Consulta para eliminar un usuario de la
     * base de datos, primero se realiza una busqueda
     * de este, si se encuentran resultados se ejecuta
     * el delete.
     * @param  [String] $id Representa el id del usuario.
     * @return [void]    usuario eliminado.
     */
    public function delete_user($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('usuarios');

        if($query)
        {
            $this->db->where('id', $id);
            $this->db->delete('usuarios');
        }       
    }
}

/* End of file usuario_model.php */
/* Location: ./application/models/usuario_model.php */