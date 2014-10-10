<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo del módulo editoriales, en esta clase se hacen todas las consultas
 * relacionadas con la gestión de editoriales, extiende del core del modelo
 * de codeigniter, carga la base de datos.
 * @author Cristia Andres Cuspoca <cristian.cuspoca@correounivalle.edu.co>
 * @version 1.0
 */
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

	/**
	 * Crear un nuevo autor.
	 * @param  String $nombre nombr del nuevo editorial
	 * @return true/false     true si tiene extito, fale si falla.
	 */
	public function create($nombre)
	{
		$data = array('nombre' => $nombre);
		return $this->db->insert('editorial', $data);
	}

	/**
	 * Consulta los autores que cumplen con el valor que se envía como
	 * Parámetro.
	 * @param  String $query valor de búsqueda puede ser un id o un nombre
	 * @return array        retorna un array de autores que coinciden con
	 *                      el valor de búsqueda, en caso de fallo
	 *                      retorna un array vacío.
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
	 * @param  String $nombre nombre que tendrá el autor
	 * @return true/false     true si éxito, false si falla
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