<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autores_model extends CI_Model {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->load->database();		
	}

	/**
	 * Obtiene los autores de un documento especifico, si se envia como true
	 * la variable $with_id se inserta en el select el id del autor, caso contrario
	 * se consulta solo su nombre.
	 * @param  [type]  $id_doc  Docuemnto especifico del cual se consultaran sus autores.
	 * @param  boolean $with_id true/false si es true se consulta nombre e id del autor,
	 *                          si es false se consulta solo su nombre.
	 * @return array           array de autores, si no hay resultados se retorna un array.
	 */
	/*public function get_autores_doc($id_doc, $with_id=FALSE)
	{
		if($with_id)
		{
			$this->db->select('autores.id, autores.nombre');
		}
		else
		{
			$this->db->select('autores.nombre');
		}		
		$this->db->from('autores');
		$this->db->join('escrito', 'escrito.id_autor = autores.id', 'inner');
		$this->db->where('escrito.id_documento', $id_doc);
		$this->db->order_by("nombre", "asc");
		$result = $this->db->get();
		if($result->num_rows() > 0)
        {
           	return $result->result_array();
        }
        return array();
	}*/

	/**
	 * Obtener todos los autores de la base de datos
	 * @return array array de autores
	 */
	public function get_autores()
	{
		$this->db->order_by("nombre", "asc");
		$query = $this->db->get('autores');
		// 
		if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
	}

	/**
	 * Consulta los autores que cumplen con el valor que se envia como
	 * parametro.
	 * @param  String $query valor de busqueda puede ser un id o un nombre
	 * @return array        retorna un array de autores que coinciden con
	 *                      el valor de busqueda, en caso de fallo
	 *                      retorna un array vacio.
	 */
	public function get_name_id($query)
	{
		$this->db->or_like('id', $query);
		$this->db->or_like('nombre', $query);
		$this->db->order_by('id', 'asc');
		$consulta = $this->db->get('autores');
		if($consulta->num_rows() > 0)
        {
            return $consulta->result_array();
        }else
        {
        	return array();
        }
	}

	/**
	 * Actualizar un autor
	 * @param  String $id     id del autor a actualizar.
	 * @param  String $nombre nombre que tendra el autor
	 * @return true/false     true si exito, false si falla
	 */
	public function update($id, $nombre)
	{
		$data = array('nombre' => $nombre);
        $this->db->where('id', $id);
        return $this->db->update('autores', $data);
	}

	/**
	 * Crear un nuevo autor
	 * @param  String $nombre Nombre del nuevo autor
	 * @return true/false         true si la consulta tiene exito, false si falla
	 */
	public function create($nombre)
	{
		$data = array('nombre' => $nombre );		
		return $this->db->insert('autores', $data);
	}

}

/* End of file autores_model.php */
/* Location: ./application/models/autores_model.php */