<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editoriales_model extends CI_Model {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->load->database();		
	}

	/**
	 * Obtener todos los editoriales de a base de datos
	 * @return array(editoriales) array de editoriales
	 */
	public function get_editoriales()
	{
		$query = $this->db->get('editorial');
		$this->db->order_by("nombre", "asc");
		if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
	}

	public function create($nombre)
	{
		$data = array('nombre' => $nombre);
		return $this->db->insert('editorial', $data);
	}

	/**
	 * Consulta los autores que cumplen con el valor que se envia como
	 * parametro.
	 * @param  String $query valor de busqueda puede ser un id o un nombre
	 * @return array        retorna un array de autores que coinciden con
	 *                      el valor de busqueda, en caso de fallo
	 *                      retorna un array vacio.
	 */
	public function get_editoriales_by($query)
	{
		$this->db->or_like('id', $query);
		$this->db->or_like('nombre', $query);
		$this->db->order_by('id', 'asc');
		$consulta = $this->db->get('editorial');
		if($consulta->num_rows() > 0)
        {
            return $consulta->result_array();
        }else
        {
        	return array();
        }
	}

	/**
	 * Actualizar un Editorial
	 * @param  String $id     id del autor a actualizar.
	 * @param  String $nombre nombre que tendra el autor
	 * @return true/false     true si exito, false si falla
	 */
	public function update($id, $nombre)
	{
		$data = array('nombre' => $nombre);
        $this->db->where('id', $id);
        return $this->db->update('editorial', $data);
	}

}

/* End of file editoriales_model.php */
/* Location: ./application/models/editoriales_model.php */