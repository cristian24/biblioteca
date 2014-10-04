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

    public function generate_code()
    {
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $cad = "";
        for($i=0;$i<10;$i++) {
            $cad .= substr($str,rand(0,62),1);
        }
        return $cad;
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
     * Obtener el login y password de un usuario de acuerdo a su corre
     * @param  String $correo campo unico para cada usuario.
     * @return Array()         array con los datos del usuario, se retorna un array
     *                         vacio si la consulta no arroja resultados.
     */
    public function get_pass_login($correo)
    {
        $this->db->select('id, login, pass, code');
        $this->db->where('correo', $correo);
        $query = $this->db->get('usuarios');
        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }
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
            return $query->row_array();
        }
        return 'no found';
    }

    /**
     * Busqueda de un codigo, si exite se retorna el codigo, caso contrario
     * se retorna un false.
     * @param  String $code codigo a buscar
     * @return array()/false       array con el valor solicitado o false.
     */
    public function get_code($code, $id=false)
    {
        if($id)
        {
            $data = array('code' => $code, 'id' => $id);
        }else
        {
            $data = array('code' => $code);
        }
        $this->db->select('code');        
        $this->db->where($data);
        $query = $this->db->get('usuarios'); 
        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }
        return FALSE;
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
        //generamos codigo
        $code = $this->generate_code();
        $existe = $this->get_code($code);

        //si ya existe ese codigo generamos uno nuevo
        while ( ! empty($existe)) {
            $code = $this->generate_code();
            $existe = $this->get_code($code);
        }

    	if($perfil)
    	{
    		$data = array(
    				'nombre'    => $nombre,
    				'login'     => $login,
    				'pass'	    => do_hash($pass, 'md5'),
    				'correo'    => $correo,
    				'telefono'  => $telefono,
    				'perfil'    => $perfil,
                    'code'      => $code
    			);
    		return $this->db->insert('usuarios', $data);
    	}else
    	{
    		$data = array(
    				'nombre'    => $nombre,
    				'login'     => $login,
    				'pass'	    => do_hash($pass, 'md5'),
    				'correo'    => $correo,
    				'telefono'  => $telefono,
    				'perfil'    => 'Usuario',
                    'code'      => $code
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

    public function update_pass($id, $pass)
    {
        $data = array(
                    'pass' => do_hash($pass, 'md5')
                );
        $this->db->where('id', $id);
        return $this->db->update('usuarios', $data);
    }

    public function update_code($id, $code_last)
    {
        $code = $this->generate_code();
        $existe = $this->get_code($code);

        //si ya existe ese codigo generamos uno nuevo
        while ( ! empty($existe)) {
            $code = $this->generate_code();
            $existe = $this->get_code($code);
        }
        $data = array('code' => $code);
        $this->db->where('id', $id);
        $this->db->where('code', $code_last);
        return $this->db->update('usuarios', $data);
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
            return $this->db->delete('usuarios');
        }       
    }
}

/* End of file usuario_model.php */
/* Location: ./application/models/usuario_model.php */