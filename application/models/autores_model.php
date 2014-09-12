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
	public function get_autores_doc($id_doc, $with_id=FALSE)
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
	}

	/**
	 * Obtener todos los autores de la base de datos
	 * @return array array de autores
	 */
	public function get_autores()
	{
		$query = $this->db->get('autores');
		$this->db->order_by("nombre", "asc"); 
		if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
	}

	public function create($nombre)
	{
		$data = array('nombre' => $nombre );		
		return $this->db->insert('autores', $data);
	}

}

/* End of file autores_model.php */
/* Location: ./application/models/autores_model.php */