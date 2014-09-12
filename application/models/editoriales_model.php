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

}

/* End of file editoriales_model.php */
/* Location: ./application/models/editoriales_model.php */